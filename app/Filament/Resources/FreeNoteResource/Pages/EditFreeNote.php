<?php

namespace App\Filament\Resources\FreeNoteResource\Pages;

use App\Filament\Resources\FreeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeNote extends EditRecord
{
    protected static string $resource = FreeNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
