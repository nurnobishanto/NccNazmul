<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\ExamPaper;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Resource';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')->disabled(),
                Forms\Components\TextInput::make('payment_method')->disabled(),
                Forms\Components\TextInput::make('customer_msisdn')->disabled(),
                Forms\Components\TextInput::make('merchant_invoice_number')->disabled(),
                Forms\Components\Select::make('transaction_status')->options(['pending' => 'PENDING','COMPLETED' => 'COMPLETED'])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.user.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order.order_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('transaction_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('amount')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('transaction_status')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->searchable()->sortable(),
            
            ])->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')->url(fn (Payment $record): string => route('payment_success',['id' => $record->id]).'?password='.Hash::make(env('APP_NAME'))),
                Action::make('invoice')->url(fn (Payment $record): string => route('invoice',['id' => $record->id])),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}