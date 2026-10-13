<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationGroup = 'Katalog & Portofolio';
    protected static ?string $navigationLabel = 'Layanan Interior';
    protected static ?string $modelLabel = 'Layanan';
    protected static ?string $pluralModelLabel = 'Layanan Interior';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Layanan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Service::class, 'slug', ignoreRecord: true),
                        Forms\Components\Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('full_description')
                            ->label('Deskripsi Lengkap')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Visual & Material')
                    ->schema([
                        Forms\Components\TextInput::make('cover_image')
                            ->label('URL / Path Foto Sampul')
                            ->helperText('Contoh: https://images.unsplash.com/... atau path upload')
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('gallery_images')
                            ->label('Foto Galeri Tambahan (URL / Path)')
                            ->placeholder('Tambah URL foto lalu tekan enter')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('materials_used')
                            ->label('Material & Finishing Unggulan')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('benefits')
                            ->label('Keunggulan / Fitur Layanan')
                            ->placeholder('Tambah keunggulan lalu tekan enter')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Pengaturan Tampilan')
                    ->schema([
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
