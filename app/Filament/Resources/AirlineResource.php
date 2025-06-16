<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AirlineResource\Pages;
use App\Imports\AirlinesImport;
use App\Models\Airline;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class AirlineResource extends Resource
{
    protected static ?string $model = Airline::class;
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('iata_code')->required()->maxLength(3),
                Forms\Components\FileUpload::make('logo')->image()->directory('airline-logos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->width(80),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('iata_code')->searchable(),
            ])
            ->headerActions([
                Action::make('importAirlines')
                    ->label(__('import_airlines_label'))
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        Forms\Components\FileUpload::make('attachment')
                            ->label(__('import_file_upload_label'))
                            ->required()
                            ->acceptedFileTypes(['text/csv'])
                            ->disk('local'), // Simpan sementara di disk lokal
                        Forms\Components\MarkdownEditor::make('notes')
                            ->columnSpanFull()
                            ->disabled()
                            ->default(fn() => __('import_airline_instructions_markdown', ['url' => route('download.airline_template')]))
                    ])
                    ->action(function (array $data) {
                        try {
                            // Ambil path file sementara dari data form
                            $temporaryPath = $data['attachment'];

                            // Tentukan path tujuan di dalam public storage
                            $destinationPath = 'imports/airlines/' . basename($temporaryPath);

                            // Pindahkan file dari disk sementara (local) ke disk permanen (public)
                            Storage::disk('public')->put($destinationPath, Storage::disk('local')->get($temporaryPath));

                            // Jalankan impor dari file yang sudah disimpan di disk 'public'
                            Excel::import(new \App\Imports\AirlinesImport, $destinationPath, 'public');
                            
                            Notification::make()
                                ->title(__('import_airline_success_title'))
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title(__('import_error_title'))
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAirlines::route('/'),
            'create' => Pages\CreateAirline::route('/create'),
            'edit' => Pages\EditAirline::route('/{record}/edit'),
        ];
    }    
}
