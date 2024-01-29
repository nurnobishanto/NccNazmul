<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeNoteResource\Pages;
use App\Filament\Resources\FreeNoteResource\RelationManagers;
use App\Models\FreeNote;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FreeNoteResource extends Resource
{
    protected static ?string $model = FreeNote::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Resource';
    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('slug')->unique(ignoreRecord: true)->visibleOn(['edit','view'])->columnSpanFull(),
                TextInput::make('name')
                    ->required()
                    ->placeholder('Enter Fre note name'),

                Forms\Components\TextInput::make('link')->url(),
                Forms\Components\FileUpload::make('file')
                    ->acceptedFileTypes(['application/pdf']),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\Textarea::make('details')
                    ->maxLength(250)
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('count')->label('Download Count')
                    ->sortable(),
            ])
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
            'index' => Pages\ListFreeNotes::route('/'),
            'create' => Pages\CreateFreeNote::route('/create'),
            'edit' => Pages\EditFreeNote::route('/{record}/edit'),
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
