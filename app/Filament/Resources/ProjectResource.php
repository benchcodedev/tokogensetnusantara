<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Katalog & Portofolio';
    protected static ?string $navigationLabel = 'Proyek Portofolio';
    protected static ?string $modelLabel = 'Proyek';
    protected static ?string $pluralModelLabel = 'Proyek Portofolio';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Proyek')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori Proyek')
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Proyek')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(Project::class, 'slug', ignoreRecord: true),
                        Forms\Components\TextInput::make('client_name')
                            ->label('Nama Klien / Inisial')
                            ->placeholder('Contoh: Private Residence, Pak H., Ibu V.'),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->placeholder('Contoh: Pondok Indah, Jakarta Selatan'),
                        Forms\Components\TextInput::make('project_year')
                            ->label('Tahun Pengerjaan')
                            ->default(date('Y')),
                        Forms\Components\TextInput::make('type')
                            ->label('Tipe / Luas Proyek')
                            ->placeholder('Contoh: Penthouse 350 m², Modern Classical Villa'),
                    ])->columns(2),

                Forms\Components\Section::make('Deskripsi & Material')
                    ->schema([
                        Forms\Components\Textarea::make('summary')
                            ->label('Ringkasan Proyek')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Lengkap Pengerjaan')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('materials')
                            ->label('Material & Finishing yang Digunakan')
                            ->placeholder('Contoh: Marmer Statuario Italia, Walnut Wood Veneer, Kuningan Brushed Gold')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Foto & Video')
                    ->schema([
                        Forms\Components\TextInput::make('cover_image')
                            ->label('Foto Sampul (Cover Image)')
                            ->helperText('URL gambar Unsplash atau path storage')
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('gallery_images')
                            ->label('Galeri Foto Proyek')
                            ->placeholder('Tambah URL foto galeri lalu tekan enter')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('video_url')
                            ->label('URL Video Proyek (Opsional)')
                            ->placeholder('https://www.youtube.com/embed/...'),
                    ]),

                Forms\Components\Section::make('Pengaturan Publikasi')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Proyek Pilihan (Tampil di Beranda)')
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
                    ->label('Judul Proyek')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
