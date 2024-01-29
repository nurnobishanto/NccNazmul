<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Identity extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.identity';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    public $site_title;
    public $site_tagline;
    public $site_description;
    public $site_address;
    public $site_copyright;
    public $site_logo;
    public $site_dark_logo;
    public $site_footer_logo;
    public $site_footer_dark_logo;
    public $site_favicon;
    public $site_phone;
    public $site_phone_2;
    public $site_email;
    public $site_facebook;
    public $site_twitter;
    public $site_instagram;
    public $site_linkedin;
    public $site_youtube;
    public $preloading_text;

    public function mount()
    {
        $this->form->fill([
            'site_title' => getSetting('site_title'),
            'site_tagline' => getSetting('site_tagline'),
            'site_description' => getSetting('site_description'),
            'site_address' => getSetting('site_address'),
            'site_copyright' => getSetting('site_copyright'),
            'site_logo' => getSetting('site_logo'),
            'site_dark_logo' => getSetting('site_dark_logo'),
            'site_footer_logo' => getSetting('site_footer_logo'),
            'site_footer_dark_logo' => getSetting('site_footer_dark_logo'),
            'site_favicon' => getSetting('site_favicon'),
            'preloading_text' => getSetting('preloading_text'),
            'site_phone' => getSetting('site_phone'),
            'site_phone_2' => getSetting('site_phone_2'),
            'site_email' => getSetting('site_email'),
            'site_facebook' => getSetting('site_facebook'),
            'site_twitter' => getSetting('site_twitter'),
            'site_instagram' => getSetting('site_instagram'),
            'site_linkedin' => getSetting('site_linkedin'),
            'site_youtube' => getSetting('site_youtube'),
        ]);
    }
    public function submit()
    {
        $state = $this->form->getState();
        $site_logo = $state['site_logo'];
        $site_dark_logo = $state['site_dark_logo'];
        $site_footer_logo = $state['site_footer_logo'];
        $site_footer_dark_logo = $state['site_footer_dark_logo'];
        $site_favicon = $state['site_favicon'];

        setSetting('site_title',$this->site_title);
        setSetting('site_tagline',$this->site_tagline);
        setSetting('site_description',$this->site_description);
        setSetting('site_address',$this->site_address);
        setSetting('site_copyright',$this->site_copyright);
        setSetting('site_logo',$site_logo);
        setSetting('site_dark_logo',$site_dark_logo);
        setSetting('site_footer_logo',$site_footer_logo);
        setSetting('site_footer_dark_logo',$site_footer_dark_logo);
        setSetting('site_favicon',$site_favicon);
        setSetting('preloading_text',$this->preloading_text);
        setSetting('site_phone',$this->site_phone);
        setSetting('site_phone_2',$this->site_phone_2);
        setSetting('site_email',$this->site_email);
        setSetting('site_facebook',$this->site_facebook);
        setSetting('site_twitter',$this->site_twitter);
        setSetting('site_instagram',$this->site_instagram);
        setSetting('site_linkedin',$this->site_linkedin);
        setSetting('site_youtube',$this->site_youtube);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
    protected function getFormSchema(): array
    {
        return [
            Section::make('General')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->schema([
                    TextInput::make('site_title')
                        ->label('Site Title (site_title)')
                        ->placeholder('Enter Site Title'),
                    TextInput::make('site_tagline')
                        ->label('Site tagline (site_tagline)')
                        ->placeholder('Enter Site Tagline'),
                    Textarea::make('site_description')
                        ->label('Site description (site_description)')
                        ->placeholder('Enter Site description')->columnSpan(2),
                    Textarea::make('site_address')
                        ->label('Site address (site_address)')
                        ->placeholder('Enter Site address'),
                    Textarea::make('site_copyright')
                        ->label('Site copyright (site_copyright)')
                        ->placeholder('Enter Site copyright'),

                    FileUpload::make('site_logo')
                        ->label('Site Logo (site_logo)')
                        ->image()
                        ->maxSize(500),
                    FileUpload::make('site_dark_logo')
                        ->label('Site Dark Logo (site_dark_logo)')
                        ->image()
                        ->maxSize(500),
                    FileUpload::make('site_footer_logo')
                        ->label('Site Footer Logo (site_footer_logo)')
                        ->image()
                        ->maxSize(500),
                    FileUpload::make('site_footer_dark_logo')
                        ->label('Site Footer Dark Logo (site_footer_dark_logo)')
                        ->image()
                        ->maxSize(500),
                    FileUpload::make('site_favicon')
                        ->label('Site Favicon (site_favicon)')
                        ->image()
                        ->maxSize( 200) // 200 KB (200 * 1024 bytes)
                        ->imageCropAspectRatio('1:1'),
                    Textarea::make('preloading_text')
                        ->label('Site Pre Loading Text (preloading_text)')
                        ->placeholder('Enter Site Pre Loading Text'),


                ]),
            Section::make('Contact Information')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->schema([
                    TextInput::make('site_phone')
                        ->label('Site phone (site_phone)')
                        ->placeholder('Enter Site phone'),
                    TextInput::make('site_phone_2')
                        ->label('Site phone 2 (site_phone_2)')
                        ->placeholder('Enter Site phone 2'),
                    TextInput::make('site_email')
                        ->email()
                        ->label('Site email (site_email)')
                        ->placeholder('Enter Site email'),
                    TextInput::make('site_facebook')
                        ->url()
                        ->label('Site facebook (site_facebook)')
                        ->placeholder('Enter Site facebook'),
                    TextInput::make('site_twitter')
                        ->url()
                        ->label('Site twitter (site_twitter)')
                        ->placeholder('Enter Site twitter'),
                    TextInput::make('site_instagram')
                        ->url()
                        ->label('Site instagram (site_instagram)')
                        ->placeholder('Enter Site instagram'),
                    TextInput::make('site_linkedin')
                        ->url()
                        ->label('Site linkedin (site_linkedin)')
                        ->placeholder('Enter Site linkedin'),
                    TextInput::make('site_youtube')
                        ->url()
                        ->label('Site youtube (site_youtube)')
                        ->placeholder('Enter Site youtube'),



                ]),

        ];
    }
}
