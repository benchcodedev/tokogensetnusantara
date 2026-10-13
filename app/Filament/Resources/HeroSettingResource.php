<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSettingResource\Pages;
use App\Models\HeroSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSettingResource extends Resource
{
    protected static ?string $model = HeroSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Konten Utama';
    protected static ?string $navigationLabel = 'Hero Home Banner';
    protected static ?string $modelLabel = 'Pengaturan Hero';
    protected static ?string $pluralModelLabel = 'Pengaturan Hero';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Teks & Headline Hero')
                    ->description('Teks utama pada hero split panel emas')
                    ->schema([
                        Forms\Components\TextInput::make('headline')
                            ->label('Headline (Judul Utama)')
                            ->required()
                            ->maxLength(255)
                            ->default('Tempat Kemewahan Menemukan Rumahnya'),
                        Forms\Components\Textarea::make('subheadline')
                            ->label('Subheadline (Paragraf Pendukung)')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('small_description')
                            ->label('Deskripsi Kecil di Kanan Bawah Panel')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Visual Hero & Video')
                    ->description('Foto interior sebelah kiri dan kartu video inset')
                    ->schema([
                        Forms\Components\TextInput::make('hero_image')
                            ->label('Foto Hero Utama (Kiri, Full Height)')
                            ->helperText('Bisa berupa URL gambar Unsplash atau path storage')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('inset_image')
                            ->label('Foto Kartu Inset (Di Tengah Sambungan)')
                            ->helperText('Bisa berupa URL gambar atau path storage'),
                        Forms\Components\TextInput::make('inset_video_url')
                            ->label('URL Video Proyek (Modal Play)')
                            ->helperText('Contoh: https://www.youtube.com/embed/ScMzIvxBSi4 atau https://youtube.com/watch?v=...'),
                    ])->columns(2),

                Forms\Components\Section::make('Tombol & CTA')
                    ->schema([
                        Forms\Components\TextInput::make('cta_text')
                            ->label('Teks Tombol Utama')
                            ->default('Lihat Portofolio')
                            ->required(),
                        Forms\Components\TextInput::make('cta_link')
                            ->label('Link Tombol Utama')
                            ->default('/portofolio')
                            ->required(),
                        Forms\Components\TextInput::make('contact_btn_text')
                            ->label('Teks Tombol Kontak (Navigasi Emas)')
                            ->default('Hubungi Kami')
                            ->required(),
                        Forms\Components\TextInput::make('contact_btn_link')
                            ->label('Link Tombol Kontak')
                            ->default('https://wa.me/6283872500925')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Angka Pencapaian (Stats Strip)')
                    ->schema([
                        Forms\Components\TextInput::make('stats_projects')
                            ->label('Proyek Selesai')
                            ->default('350+')
                            ->required(),
                        Forms\Components\TextInput::make('stats_years')
                            ->label('Tahun Pengalaman')
                            ->default('12+')
                            ->required(),
                        Forms\Components\TextInput::make('stats_showrooms')
                            ->label('Jumlah Showroom')
                            ->default('3')
                            ->required(),
                        Forms\Components\TextInput::make('stats_satisfaction')
                            ->label('Kepuasan Klien')
                            ->default('99%')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('headline')
                    ->label('Headline')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stats_projects')
                    ->label('Proyek'),
                Tables\Columns\TextColumn::make('stats_years')
                    ->label('Pengalaman'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSettings::route('/'),
            'create' => Pages\CreateHeroSetting::route('/create'),
            'edit' => Pages\EditHeroSetting::route('/{record}/edit'),
        ];
    }
}
