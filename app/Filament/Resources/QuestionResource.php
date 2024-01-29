<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\ExamPaper;
use App\Models\Question;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Exam System';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Questions Title')->columnSpan('full'),
                Select::make('subject_id')
                    ->relationship('subject', 'name')->required(),

                 Select::make('exam_papers')
                     ->multiple()
                  ->relationship('exam_papers', 'name'),
                FileUpload::make('image'),
                Textarea::make('description')->label('Questions Description'),
                TextInput::make('op1')->required()->label('Option A'),
                TextInput::make('op2')->required()->label('Option B'),
                TextInput::make('op3')->required()->label('Option C'),
                TextInput::make('op4')->required()->label('Option D'),
                Select::make('ca')->required()->label('Select Correct Answer')
                    ->options([
                        'op1' => 'Option A',
                        'op2' => 'Option B',
                        'op3' => 'Option C',
                        'op4' => 'Option D',
                    ]),
                FileUpload::make('explain_img')->label('Explain Image'),
                Textarea::make('explain')->label('Questions Explain')->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('op1')
                    ->label('Option A')
                    ->searchable(),
                Tables\Columns\TextColumn::make('op2')
                    ->label('Option B')
                    ->searchable(),
                Tables\Columns\TextColumn::make('op3')
                    ->label('Option C')
                    ->searchable(),
                Tables\Columns\TextColumn::make('op4')
                    ->label('Option D')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('ca')->options([
                    'op1' => 'Option A',
                    'op2' => 'Option B',
                    'op3' => 'Option C',
                    'op4' => 'Option D',
                ])->label('Correct Ans')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->options(Subject::all()->pluck('name','id'))
                    ->label('Subject'),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
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
