<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EbookResource\Pages;
use App\Filament\Resources\EbookResource\RelationManagers;
use App\Models\Ebook;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EbookResource extends Resource
{
    protected static ?string $model = Ebook::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Resource';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Enter E-Book name')->columnSpanFull(),
                TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->visibleOn(['edit','view'])
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options([
                        'free' => 'Free',
                        'paid' => 'Paid',
                    ])
                    ->required(),
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
                Tables\Columns\BadgeColumn::make('type'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('count')->label('Download Count')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                    'free' => 'Free',
                    'paid' => 'Paid',
                ]),
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
            'index' => Pages\ListEbooks::route('/'),
            'create' => Pages\CreateEbook::route('/create'),
            'edit' => Pages\EditEbook::route('/{record}/edit'),
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
