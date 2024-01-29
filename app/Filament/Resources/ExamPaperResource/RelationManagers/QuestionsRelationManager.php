<?php

namespace App\Filament\Resources\ExamPaperResource\RelationManagers;

use App\Models\Subject;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;


class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Questions Title')->columnSpan('full'),
                Select::make('subject_id')
                    ->relationship('subject', 'name')->required(),
                FileUpload::make('image'),
                Textarea::make('description')->label('Questions Description')->columnSpan('full'),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
                ])->label('Correct Ans')->disabled()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_id')
                    ->options(Subject::all()->pluck('name','id'))
                    ->label('Subject'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
