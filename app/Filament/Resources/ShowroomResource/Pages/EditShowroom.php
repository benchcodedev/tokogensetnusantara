<?php

namespace App\Filament\Resources\ShowroomResource\Pages;

use App\Filament\Resources\ShowroomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShowroom extends EditRecord
{
    protected static string $resource = ShowroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
