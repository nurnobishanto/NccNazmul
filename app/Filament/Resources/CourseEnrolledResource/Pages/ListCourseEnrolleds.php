<?php

namespace App\Filament\Resources\CourseEnrolledResource\Pages;

use App\Filament\Resources\CourseEnrolledResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseEnrolleds extends ListRecords
{
    protected static string $resource = CourseEnrolledResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
