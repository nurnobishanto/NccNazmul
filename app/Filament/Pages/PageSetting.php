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

    public $home_page_title;
    public $home_page_description;
    public $about_page_title;
    public $about_page_heading;
    public $about_page_description;
    public $about_page_image;


    public function mount()
    {
        $this->form->fill([

            'home_page_title' => getSetting('home_page_title'),
            'home_page_description' => getSetting('home_page_description'),

            'about_page_title' => getSetting('about_page_title'),
            'about_page_heading' => getSetting('about_page_heading'),
            'about_page_description' => getSetting('about_page_description'),
            'about_page_image' => getSetting('about_page_image'),

        ]);
    }
    public function submit()
    {
        $state = $this->form->getState();

        $about_page_image = $state['about_page_image'];



        setSetting('home_page_title',$this->home_page_title);
        setSetting('home_page_description',$this->home_page_description);


        setSetting('about_page_title',$this->about_page_title);
        setSetting('about_page_heading',$this->about_page_heading);
        setSetting('about_page_description',$this->about_page_description);
        setSetting('about_page_image',$about_page_image);

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

                    Textarea::make('home_page_description')
                        ->label('Home Page description (home_page_description)')
                        ->placeholder('Enter Home Page description')
                        ->columnSpan(2),

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



                ]),


        ];
    }
}
