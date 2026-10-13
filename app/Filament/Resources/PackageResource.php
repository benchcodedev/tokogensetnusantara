<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Katalog & Portofolio';
    protected static ?string $navigationLabel = 'Paket & Estimasi Harga';
    protected static ?string $modelLabel = 'Paket Harga';
    protected static ?string $pluralModelLabel = 'Paket & Estimasi Harga';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Paket')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Package::class, 'slug', ignoreRecord: true),
                        Forms\Components\TextInput::make('badge')
                            ->label('Badge Label (Opsional)')
                            ->placeholder('Contoh: Terpopuler, Signature, Best Value'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Paket')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Penetapan Harga & WhatsApp')
                    ->schema([
                        Forms\Components\TextInput::make('price_start')
                            ->label('Harga Mulai Dari (Nominal Angka)')
                            ->numeric()
                            ->default(0)
                            ->helperText('Contoh: 4000000 atau 45000000'),
                        Forms\Components\TextInput::make('price_display')
                            ->label('Teks Tampilan Harga')
                            ->placeholder('Mulai Rp45 Juta atau Mulai Rp4 Jt/m²')
                            ->required(),
                        Forms\Components\TextInput::make('unit_label')
                            ->label('Satuan Unit (Opsional)')
                            ->placeholder('per meter persegi / per unit'),
                        Forms\Components\Textarea::make('whatsapp_message')
                            ->label('Pesan Otomatis WhatsApp')
                            ->placeholder('Halo Abadi Jaya, saya tertarik konsultasi paket Master Bedroom...')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Harga')
                            ->default('Harga setelah diskon promosi, dapat disesuaikan dengan dimensi & spesifikasi material.')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Fitur & Prioritas')
                    ->schema([
                        Forms\Components\TagsInput::make('features')
                            ->label('Daftar Spesifikasi / Fitur yang Didapat')
                            ->placeholder('Tambah item lalu tekan enter')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_popular')
                            ->label('Sorot sebagai Paket Populer')
                            ->default(false),
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
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_display')
                    ->label('Tampilan Harga'),
                Tables\Columns\IconColumn::make('is_popular')
                    ->label('Populer')
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
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
