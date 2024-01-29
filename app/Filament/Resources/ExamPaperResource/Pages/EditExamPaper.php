<?php

namespace App\Filament\Resources\ExamPaperResource\Pages;

use App\Filament\Resources\ExamPaperResource;
use App\Models\ExamPaper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;

class EditExamPaper extends EditRecord
{
    protected static string $resource = ExamPaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\Action::make('clone')
                ->url(fn (ExamPaper $record): string => route('ep.clone', $record)),
            Actions\Action::make('start')
                ->label('Start')
                ->url(fn (ExamPaper $record): string => route('start', $record)),
            Actions\Action::make('download')
                ->label('PDF')
                ->url(fn (ExamPaper $record): string => route('question', $record)),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
