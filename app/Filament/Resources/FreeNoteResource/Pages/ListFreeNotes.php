<?php

namespace App\Filament\Resources\FreeNoteResource\Pages;

use App\Filament\Resources\FreeNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeNotes extends ListRecords
{
    protected static string $resource = FreeNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
