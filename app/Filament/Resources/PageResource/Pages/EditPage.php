<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Page;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\Action::make('editor')
                ->url(fn (Page $record): string => route('website.page.editor', $record)),
            Actions\Action::make('visit')
                ->url(fn (Page $record): string => route('website.page', $record->slug)),

            Actions\DeleteAction::make(),
        ];
    }
}
