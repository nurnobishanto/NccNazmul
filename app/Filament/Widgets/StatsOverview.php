<?php

namespace App\Filament\Widgets;

use App\Models\Batch;
use App\Models\Category;
use App\Models\ExamCategory;
use App\Models\ExamPaper;
use App\Models\Post;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Student', User::count()),
            Stat::make('Total Batch', Batch::count()),
            Stat::make('Total Subject', Subject::count()),
            Stat::make('Total Exam Category', ExamCategory::count()),
            Stat::make('Total Exam Paper', ExamPaper::count()),
            Stat::make('Total Questions', Question::count()),
            Stat::make('Total Category', Category::count()),
            Stat::make('Published posts', Post::where('status','published')->count()),
            Stat::make('Daft posts', Post::where('status','draft')->count()),
        ];
    }
}
