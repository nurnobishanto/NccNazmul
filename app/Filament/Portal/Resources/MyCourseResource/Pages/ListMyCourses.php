<?php

namespace App\Filament\Portal\Resources\MyCourseResource\Pages;

use App\Filament\Portal\Resources\MyCourseResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMyCourses extends ListRecords
{
    protected static string $resource = MyCourseResource::class;
    protected function getTableQuery(): Builder
    {
        $user = auth()->user();
        return $user->courses()->getQuery();
    }
    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
