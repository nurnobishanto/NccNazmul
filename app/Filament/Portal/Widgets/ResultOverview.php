<?php

namespace App\Filament\Portal\Widgets;

use App\Models\Batch;
use App\Models\Category;
use App\Models\ExamCategory;
use App\Models\ExamPaper;
use App\Models\Post;
use App\Models\Question;
use App\Models\Result;
use App\Models\Subject;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ResultOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Exam Attempt', Result::where('user_id',auth()->user()->id)->count()),
            Stat::make('Correct Answer', Result::where('user_id',auth()->user()->id)->sum('ca')),
            Stat::make('Wrong Answer', Result::where('user_id',auth()->user()->id)->sum('wa')),
        ];
    }
}
