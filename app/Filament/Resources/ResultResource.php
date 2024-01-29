<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResultResource\Pages;
use App\Filament\Resources\ResultResource\RelationManagers;
use App\Models\ExamPaper;
use App\Models\Result;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResultResource extends Resource
{
    protected static ?string $model = Result::class;
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Exam System';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('exam_paper_id')
                    ->relationship('exam_paper', 'name'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('total_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ca')
                    ->label('Correct Ans')
                    ->numeric(),
                Forms\Components\TextInput::make('na')
                    ->label('Negative Ans')
                    ->numeric(),
                Forms\Components\TextInput::make('wa')
                    ->label('Wrong Ans')
                    ->numeric(),
                Forms\Components\TextInput::make('duration')

                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('exam_paper.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ca')
                    ->label('Correct Ans')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('na')
                    ->label('Negative Ans')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wa')
                    ->label('Wrong Ans')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->numeric()
                    ->state(function (Model $record): string {

                        $sec = $record->duration % 60;
                        $min = ($record->duration - $sec) / 60;
                        return $min. ' Min '.$sec.' Sec';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('exam_paper_id')
                    ->options(ExamPaper::all()->pluck('name','id'))
                    ->searchable()
                    ->label('Exam Paper'),
                Tables\Filters\SelectFilter::make('user_id')
                    ->options(User::all()->pluck('name','id'))
                    ->searchable()
                    ->label('Select Student'),
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
            'index' => Pages\ListResults::route('/'),
            'create' => Pages\CreateResult::route('/create'),
            'edit' => Pages\EditResult::route('/{record}/edit'),
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
