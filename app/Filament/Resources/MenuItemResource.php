<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-bars-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('menu_id')->label('Select Menu')
                    ->relationship('menu', 'name')->required(),
                Select::make('parent_id')
                    ->label('Select parent Item')
                    ->relationship('parent', 'title'),
                Forms\Components\TextInput::make('title')
                    ->placeholder('Enter title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->placeholder('Enter url')
                    ->maxLength(255),
                Select::make('target')->options([
                    '_self','_blank'
                ]),
                Forms\Components\TextInput::make('icon_class')
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color'),
                Forms\Components\TextInput::make('order')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
            ])->defaultSort('order','asc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
