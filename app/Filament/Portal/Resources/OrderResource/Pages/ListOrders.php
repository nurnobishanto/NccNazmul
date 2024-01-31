<?php

namespace App\Filament\Portal\Resources\OrderResource\Pages;

use App\Filament\Portal\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
    protected function getTableQuery(): Builder
    {
        $user = auth()->user();
        return Order::query()->where('user_id',$user->id)->orderBy('created_at','desc');
    }
    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
