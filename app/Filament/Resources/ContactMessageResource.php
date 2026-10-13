<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Interaksi & Showroom';
    protected static ?string $navigationLabel = 'Pesan Konsultasi Masuk';
    protected static ?string $modelLabel = 'Pesan Masuk';
    protected static ?string $pluralModelLabel = 'Pesan Konsultasi Masuk';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Klien & Konsultasi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->disabled(),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('Nomor WhatsApp')
                            ->disabled(),
                        Forms\Components\TextInput::make('project_type')
                            ->label('Jenis Proyek')
                            ->disabled(),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi Proyek')
                            ->disabled(),
                        Forms\Components\TextInput::make('budget')
                            ->label('Perkiraan Anggaran')
                            ->disabled(),
                        Forms\Components\Toggle::make('is_read')
                            ->label('Sudah Dihubungi / Dibaca')
                            ->default(false),
                        Forms\Components\Textarea::make('message')
                            ->label('Pesan dari Klien')
                            ->rows(4)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Tim Internal')
                            ->placeholder('Tulis hasil follow-up klien di sini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Klien')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('project_type')
                    ->label('Proyek'),
                Tables\Columns\TextColumn::make('budget')
                    ->label('Budget'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
