<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightResource\Pages;
use App\Imports\FlightsImport;
use App\Models\Flight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
// Tambahkan ini untuk filter
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;


class FlightResource extends Resource
{
    protected static ?string $model = Flight::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        // Metode ini tidak perlu diubah
        return $form->schema([
            Forms\Components\Select::make('airline_id')->relationship('airline', 'name')->searchable()->required(),
            Forms\Components\TextInput::make('flight_number')->required()->maxLength(255),
            Forms\Components\Select::make('direction')->options(['departure' => 'Departure', 'arrival' => 'Arrival'])->required(),
            Forms\Components\TextInput::make('city')->required()->maxLength(255),
            Forms\Components\DateTimePicker::make('scheduled_time')->required(),
            Forms\Components\DateTimePicker::make('actual_time'),
            Forms\Components\Select::make('status')->options(['Scheduled' => 'Scheduled', 'On Time' => 'On Time', 'Delayed' => 'Delayed', 'Departed' => 'Departed', 'Landed' => 'Landed', 'Cancelled' => 'Cancelled'])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Jadikan nomor penerbangan bisa dicari
                Tables\Columns\TextColumn::make('flight_number')
                    ->searchable(),
                // Jadikan nama maskapai dan kota bisa dicari
                Tables\Columns\TextColumn::make('airline.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direction')->badge(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('scheduled_time')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Scheduled' => 'gray', 'On Time' => 'success', 'Departed' => 'success', 'Landed' => 'success', 'Delayed' => 'warning', 'Cancelled' => 'danger',
                    }),
            ])
            // ↓↓↓ BAGIAN FILTER INI YANG DITAMBAHKAN ↓↓↓
            ->filters([
                SelectFilter::make('direction')
                    ->options([
                        'departure' => 'Keberangkatan',
                        'arrival' => 'Kedatangan',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'Scheduled' => 'Scheduled',
                        'On Time' => 'On Time',
                        'Delayed' => 'Delayed',
                        'Departed' => 'Departed',
                        'Landed' => 'Landed',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->multiple(), // Izinkan memilih lebih dari satu status
            ])
            // ↑↑↑ AKHIR BAGIAN FILTER ↑↑↑
            ->headerActions([
                Action::make('import')
                    ->label(__('import_flights_label'))
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        Forms\Components\FileUpload::make('attachment')
                            ->label(__('import_file_upload_label'))
                            ->required()
                            ->acceptedFileTypes(['application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/csv'])
                            ->disk('local'), // Simpan sementara di disk lokal
                        Forms\Components\MarkdownEditor::make('notes')
                            ->columnSpanFull()
                            ->disabled()
                            ->default(fn() => __('import_instructions_markdown', ['url' => route('download.flight_template')]))
                    ])
                    ->action(function (array $data) {
                        try {
                            $temporaryPath = $data['attachment'];
                            $destinationPath = 'imports/flights/' . basename($temporaryPath);
                            
                            // Pindahkan file dari disk sementara (local) ke disk permanen (public)
                            Storage::disk('public')->put($destinationPath, Storage::disk('local')->get($temporaryPath));
                            
                            // Jalankan impor dari file yang sudah disimpan di disk 'public'
                            Excel::import(new \App\Imports\FlightsImport, $destinationPath, 'public');

                            Notification::make()
                                ->title(__('import_success_title'))
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
            'index' => Pages\ListFlights::route('/'),
            'create' => Pages\CreateFlight::route('/create'),
            'edit' => Pages\EditFlight::route('/{record}/edit'),
        ];
    }    
}
