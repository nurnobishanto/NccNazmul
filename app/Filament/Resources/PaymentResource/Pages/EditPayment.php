<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Payment;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
            Actions\Action::make('approve')->url(fn (Payment $record): string => route('payment_success',['id' => $record->id]).'?password='.Hash::make(env('APP_NAME'))),
            Actions\Action::make('invoice')->url(fn (Payment $record): string => route('invoice',['id' => $record->id])),
            Actions\DeleteAction::make(),
        ];
    }
}
