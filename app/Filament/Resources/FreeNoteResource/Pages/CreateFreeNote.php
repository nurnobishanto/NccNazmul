<?php

namespace App\Filament\Resources\FreeNoteResource\Pages;

use App\Filament\Resources\FreeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFreeNote extends CreateRecord
{
    protected static string $resource = FreeNoteResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
