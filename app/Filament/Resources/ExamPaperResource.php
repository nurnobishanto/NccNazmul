<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExamPaperResource\Pages;
use App\Filament\Resources\ExamPaperResource\RelationManagers;
use App\Models\ExamPaper;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamPaperResource extends Resource
{
    protected static ?string $model = ExamPaper::class;
    protected static ?string $navigationGroup = 'Exam System';
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('batch_id')
                    ->relationship('batch','name')
                    ->required()
                    ->label('Select Batch'),
                TextInput::make('name')->required()->label('Exam Paper Title'),
                Textarea::make('description')->label('Exam Paper Description')->columnSpan('full'),
                Select::make('subject_id')
                    ->relationship('subject', 'name')->required(),
                Select::make('exam_category_id')
                    ->relationship('exam_category', 'name')->required(),
                TextInput::make('password')->label('Exam Paper Password'),
                TextInput::make('duration')->required()->label('Exam  Duration (Min)')->type('number'),
                TextInput::make('pmark')->required()->label('Positive Mark')->numeric(),
                TextInput::make('nmark')->required()->label('Negative Mark')->numeric(),
                DatePicker::make('startdate')->required(),
                TimePicker::make('starttime')->required(),
                DatePicker::make('enddate')->required(),
                TimePicker::make('endtime')->required(),
                Select::make('questions')
                    ->searchable()
                    ->columnSpanFull()
                    ->multiple()
                    ->relationship('questions','name')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->limit(20),
                TextColumn::make('questions_count')->counts('questions')->sortable(),
                TextColumn::make('duration'),
                //  TextColumn::make('pmark'),
                TextColumn::make('password'),
                TextColumn::make('results_count')->counts('results')->sortable()->label('Attempt'),
            ])
            ->filters([
                SelectFilter::make('exam_category')->relationship('exam_category', 'name'),
                Filter::make('startdate')
                    ->form([
                        Forms\Components\DatePicker::make('start_from'),
                        Forms\Components\DatePicker::make('start_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('startdate', '>=', $date),
                            )
                            ->when(
                                $data['start_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('enddate', '<=', $date),
                            );
                    }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('clone')
                    ->url(fn (ExamPaper $record): string => route('ep.clone', $record)),
                Action::make('start')
                    ->label('Start')
                    ->url(fn (ExamPaper $record): string => route('start', $record)),
                Action::make('download')
                    ->label('PDF')
                    ->url(fn (ExamPaper $record): string => route('question', $record)),
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
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExamPapers::route('/'),
            'create' => Pages\CreateExamPaper::route('/create'),
            'edit' => Pages\EditExamPaper::route('/{record}/edit'),
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
