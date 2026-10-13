<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowroomResource\Pages;
use App\Models\Showroom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShowroomResource extends Resource
{
    protected static ?string $model = Showroom::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Interaksi & Showroom';
    protected static ?string $navigationLabel = 'Lokasi Showroom';
    protected static ?string $modelLabel = 'Showroom';
    protected static ?string $pluralModelLabel = 'Lokasi Showroom';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Showroom')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Showroom')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Showroom Pondok Indah Mall 1'),
                        Forms\Components\TextInput::make('mall_name')
                            ->label('Mall / Gedung / Kawasan')
                            ->placeholder('Pondok Indah Mall 1'),
                        Forms\Components\TextInput::make('floor_unit')
                            ->label('Lantai & Nomor Unit')
                            ->placeholder('Lantai GF No. 017 & 022'),
                        Forms\Components\TextInput::make('city')
                            ->label('Kota / Wilayah')
                            ->default('Jakarta'),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Operasional')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Telepon / WhatsApp')
                            ->default('+62 838-7250-0925'),
                        Forms\Components\TextInput::make('opening_hours')
                            ->label('Jam Buka / Operasional')
                            ->default('Setiap Hari, 10.00 – 22.00 WIB'),
                        Forms\Components\TextInput::make('gmaps_link')
                            ->label('Link Google Maps (Petunjuk Arah)')
                            ->placeholder('https://maps.google.com/?q=...'),
                        Forms\Components\Textarea::make('gmaps_embed')
                            ->label('Embed URL Google Maps (Iframe Src)')
                            ->placeholder('https://www.google.com/maps/embed?...')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('image')
                            ->label('Foto Showroom (URL atau Path)')
                            ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Showroom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('floor_unit')
                    ->label('Unit / Lantai'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Kota'),
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
            'index' => Pages\ListShowrooms::route('/'),
            'create' => Pages\CreateShowroom::route('/create'),
            'edit' => Pages\EditShowroom::route('/{record}/edit'),
        ];
    }
}
