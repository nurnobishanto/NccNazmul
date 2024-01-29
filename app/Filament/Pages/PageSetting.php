<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class PageSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.page-setting';
    public $update_headline;
    public $home_page_title;
    public $home_page_description;
    public $home_page_background;
    public $about_page_title;
    public $about_page_heading;
    public $about_page_description;
    public $about_page_image;
    public $about_page_experience;
    public $about_page_students;

    public function mount()
    {
        $this->form->fill([
            'update_headline' => getSetting('update_headline'),
            'home_page_title' => getSetting('home_page_title'),
            'home_page_description' => getSetting('home_page_description'),
            'home_page_background' => getSetting('home_page_background'),
            'about_page_title' => getSetting('about_page_title'),
            'about_page_heading' => getSetting('about_page_heading'),
            'about_page_description' => getSetting('about_page_description'),
            'about_page_image' => getSetting('about_page_image'),
            'about_page_experience' => getSetting('about_page_experience'),
            'about_page_students' => getSetting('about_page_students'),
        ]);
    }
    public function submit()
    {
        $state = $this->form->getState();
        $home_page_background = $state['home_page_background'];
        $about_page_image = $state['about_page_image'];


        setSetting('update_headline',$this->update_headline);
        setSetting('home_page_title',$this->home_page_title);
        setSetting('home_page_description',$this->home_page_description);
        setSetting('home_page_background',$home_page_background);

        setSetting('about_page_title',$this->about_page_title);
        setSetting('about_page_heading',$this->about_page_heading);
        setSetting('about_page_description',$this->about_page_description);
        setSetting('about_page_image',$about_page_image);
        setSetting('about_page_experience',$this->about_page_experience);
        setSetting('about_page_students',$this->about_page_students);
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
    protected function getFormSchema(): array
    {
        return [
            Section::make('Home Page')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    TextInput::make('home_page_title')
                        ->label('Home Page title (home_page_title)')
                        ->placeholder('Enter Home Page title')
                        ->columnSpan(2),
                    TextInput::make('update_headline')
                        ->label('Home Update Headline (update_headline)')
                        ->placeholder('Enter Update Headline')
                        ->columnSpan(2),
                    RichEditor::make('home_page_description')
                        ->label('Home Page description (home_page_description)')
                        ->placeholder('Enter Home Page description'),

                    FileUpload::make('home_page_background')
                        ->label('Home Page Background (home_page_background)')
                        ->image()
                        ->maxSize(500),

                ]),
            Section::make('About Page')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    TextInput::make('about_page_title')
                        ->label('about Page title (about_page_title)')
                        ->placeholder('Enter About Page title'),
                    TextInput::make('about_page_heading')
                        ->label('About Page Heading (about_page_heading)')
                        ->placeholder('Enter About Page Heading '),
                    RichEditor::make('about_page_description')
                        ->label('About Page Description (about_page_description)')
                        ->placeholder('Enter About Page Description ')
                        ->columnSpan(2),
                    FileUpload::make('about_page_image')
                        ->label('About Page Image (about_page_image)')
                        ->image()
                        ->maxSize(500),

                    TextInput::make('about_page_experience')
                        ->label('About Page experience (about_page_experience)')
                        ->placeholder('Enter About Page experience '),
                    TextInput::make('about_page_students')
                        ->label('About Page students (about_page_students)')
                        ->placeholder('Enter About Page students '),

                ]),


        ];
    }
}
