<?php

namespace App\Filament\Portal\Widgets;

use App\Models\ExamPaper;
use App\Models\Result;
use App\Models\Subject;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;

use Illuminate\Database\Eloquent\Builder;


class ActivityList extends BaseWidget
{
    protected static string $view = 'filament.portal.widgets.activity-list';
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Latest Exam Activity';
    protected int | string | array $columnSpan = 'full';
    protected function getTableQuery(): Builder
    {
        $user = auth()->user();
        return Result::query()->where('user_id',$user->id)->orderBy('created_at','desc');
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('exam_paper.exam_category.name')->searchable(),
            TextColumn::make('exam_paper.name')->searchable(),
            TextColumn::make('total_mark')->searchable(),
            TextColumn::make('ca')->label('Correct Ans')->searchable(),
            TextColumn::make('na')->label('Not Ans')->searchable(),
            TextColumn::make('wa')->label('Wrong Ans')->searchable(),
            TextColumn::make('created_at')->date('d M y, h:m A')->label('Submitted')->searchable(),
        ];
    }
    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('exam_paper_id')->options(ExamPaper::all()->pluck('name','id'))
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('result')
                ->label('View')
                ->url(fn (Result $record): string => route('result',['result' => $record])),
        ];
    }

}
