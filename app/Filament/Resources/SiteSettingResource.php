<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Pengaturan Sistem';
    protected static ?string $navigationLabel = 'Pengaturan Situs & Kontak';
    protected static ?string $modelLabel = 'Pengaturan Situs';
    protected static ?string $pluralModelLabel = 'Pengaturan Situs';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Perusahaan')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Nama Brand / Situs')
                            ->required()
                            ->default('Abadi Jaya Furniture'),
                        Forms\Components\TextInput::make('tagline')
                            ->label('Tagline')
                            ->default('Kontraktor Interior & Custom Furniture Luxury'),
                        Forms\Components\Textarea::make('office_address')
                            ->label('Alamat Kantor Pusat / Workshop')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('footer_text')
                            ->label('Deskripsi Footer Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('Nomor WhatsApp (Angka murni diawali 62)')
                            ->helperText('Contoh: 6283872500925')
                            ->required(),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon Tampilan')
                            ->default('+62 838-7250-0925'),
                        Forms\Components\TextInput::make('email')
                            ->label('Alamat Email Resmi')
                            ->email()
                            ->default('info@abadijaya.id'),
                        Forms\Components\TextInput::make('instagram')
                            ->label('Handle Instagram')
                            ->default('@abadijaya.id'),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Link Profil Instagram')
                            ->url()
                            ->default('https://instagram.com/abadijaya.id'),
                        Forms\Components\TextInput::make('hero_video_url')
                            ->label('Video Showreel (YouTube Embed URL)')
                            ->default('https://www.youtube.com/embed/ScMzIvxBSi4'),
                    ])->columns(2),

                Forms\Components\Section::make('Metadata SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title Default')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description Default')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name')
                    ->label('Nama Situs'),
                Tables\Columns\TextColumn::make('whatsapp_number')
                    ->label('WhatsApp'),
                Tables\Columns\TextColumn::make('instagram')
                    ->label('Instagram'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Update')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
