<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\OrderResource\Pages;
use App\Filament\Portal\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TextColumn::make('items_count')->counts('items')->sortable(),
                Tables\Columns\TextColumn::make('paid_amount'),
                Tables\Columns\TextColumn::make('due'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([

            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->url(fn (Order $record): string => route('view_order',['id' => $record->id])),
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
            'index' => Pages\ListOrders::route('/'),
           //'create' => Pages\CreateOrder::route('/create'),
           // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
