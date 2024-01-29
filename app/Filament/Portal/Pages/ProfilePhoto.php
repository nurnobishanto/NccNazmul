<?php

namespace App\Filament\Portal\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ProfilePhoto extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.portal.pages.profile-photo';
    protected static ?string $navigationGroup = 'Profile';
    protected static ?int $navigationSort = 2;
    public $image;
    public function mount()
    {
        $this->form->fill([
            'image' => auth()->user()->image,
        ]);
    }
    public function submit()
    {
        $user = auth()->user();
        $state = $this->form->getState();
        $image = $state['image'];
        $user->image = $image;
        $user->update();
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
    protected function getFormSchema(): array
    {
        return [
            Section::make('General')
                ->schema([
                    FileUpload::make('image')
                        ->imageEditor()
                        ->image(),
                ])
        ];

    }

}
