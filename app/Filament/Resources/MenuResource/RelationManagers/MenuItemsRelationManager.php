<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'menu_items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
