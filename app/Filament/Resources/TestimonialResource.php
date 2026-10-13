<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Interaksi & Showroom';
    protected static ?string $navigationLabel = 'Testimoni Klien';
    protected static ?string $modelLabel = 'Testimoni';
    protected static ?string $pluralModelLabel = 'Testimoni Klien';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Klien & Ulasan')
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->label('Nama Klien')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ibu Stephanie W.'),
                        Forms\Components\TextInput::make('client_title')
                            ->label('Gelar / Jabatan / Tipe Hunian')
                            ->placeholder('Owner Penthouse Pakubuwono, Jakarta Selatan'),
                        Forms\Components\TextInput::make('project_type')
                            ->label('Jenis Pekerjaan Interior')
                            ->placeholder('Contoh: Master Bedroom & Walk-in Closet'),
                        Forms\Components\TextInput::make('rating')
                            ->label('Rating Bintang (1 - 5)')
                            ->numeric()
                            ->default(5)
                            ->minValue(1)
                            ->maxValue(5)
                            ->required(),
                        Forms\Components\Textarea::make('review')
                            ->label('Ulasan / Testimoni')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('avatar')
                            ->label('Foto Avatar Klien (URL atau Path)')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_title')
                    ->label('Hunian / Jabatan'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', $state)),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
