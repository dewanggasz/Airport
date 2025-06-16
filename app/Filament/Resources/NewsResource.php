<?php

namespace App\Filament\Resources;

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\News;
use Illuminate\Support\Str; // Import Str
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // Update slug saat selesai mengetik judul
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(News::class, 'slug', ignoreRecord: true),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('news-thumbnails'),

                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('published_at')
                    ->required()
                    ->default(now()),

                Forms\Components\Toggle::make('is_visible')
                    ->required()
                    ->label('Visible to Public?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('published_at')->date()->sortable(),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\NewsResource\Pages\ListNews::route('/'),
            'create' => \App\Filament\Resources\NewsResource\Pages\CreateNews::route('/create'),
            'edit' => \App\Filament\Resources\NewsResource\Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
