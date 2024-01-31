<?php

namespace App\Filament\Portal\Resources\MyCourseResource\Pages;

use App\Filament\Portal\Resources\MyCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyCourse extends EditRecord
{
    protected static string $resource = MyCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
