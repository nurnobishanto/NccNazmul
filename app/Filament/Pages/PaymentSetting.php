<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Log;
use Mpdf\Tag\Select;

class PaymentSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.page-setting';

    public $bkash_status;
    public $bkash_base_url;
    public $bkash_username;
    public $bkash_password;
    public $bkash_app_key;
    public $bkash_app_secret;


    public $uddoktapay_status;
    public $uddoktapay_url;
    public $uddoktapay_api_key;

    public function mount()
    {
        $this->form->fill([

            'bkash_status' => env('BKASH_STATUS'),
            'bkash_base_url' => env('BKASH_BASE_URL'),
            'bkash_username' => env('BKASH_USER_NAME'),
            'bkash_password' => env('BKASH_PASSWORD'),
            'bkash_app_key' => env('BKASH_APP_KEY'),
            'bkash_app_secret' => env('BKASH_APP_SECRET'),
            'uddoktapay_api_key' => env('UDDOKTA_API_KEY'),
            'uddoktapay_url' => env('UDDOKTA_URL'),
            'uddoktapay_status' => env('UDDOKTA_STATUS'),

        ]);
    }
    public function submit()
    {
        $envVariablesToUpdate = [
            'BKASH_STATUS' => $this->bkash_status,
            'BKASH_BASE_URL' => $this->bkash_base_url,
            'BKASH_USER_NAME' => $this->bkash_username,
            'BKASH_PASSWORD' => $this->bkash_password,
            'BKASH_APP_KEY' => $this->bkash_app_key,
            'BKASH_APP_SECRET' => $this->bkash_app_secret,

            'UDDOKTA_STATUS' => $this->uddoktapay_status,
            'UDDOKTA_URL' => $this->uddoktapay_url,
            'UDDOKTA_API_KEY' => $this->uddoktapay_api_key,
        ];
        foreach ($envVariablesToUpdate as $key => $value) {
            if (env($key) != $value) { setEnv($key, $value); }
        }



    }
    protected function getFormSchema(): array
    {

        return [
            Section::make('Bkash Settings')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('bkash_status')->options([
                        false=>'OFF',
                        true=>'ON'
                    ])->label('BKASH STATUS'),

                    \Filament\Forms\Components\Select::make('bkash_base_url')->options([
                        'https://tokenized.sandbox.bka.sh/v1.2.0-beta'=>'SANDBOX',
                        'https://tokenized.pay.bka.sh/v1.2.0-beta'=>'PRODUCTION'
                    ])->label('BKASH MODE'),
                    TextInput::make('bkash_username')->label('Bkash Username')->placeholder('Enter Bkash Username'),
                    TextInput::make('bkash_password')->label('Bkash Password')->placeholder('Enter Bkash Password'),
                    TextInput::make('bkash_app_key')->label('Bkash App Key')->placeholder('Enter Bkash App Key'),
                    TextInput::make('bkash_app_secret')->label('Bkash App Secret')->placeholder('Enter Bkash App Secret'),

                ]),
            Section::make('UddoktaPay Settings')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('uddoktapay_status')->options([
                        false=>'OFF',
                        true=>'ON'
                    ])->label('BKASH STATUS'),
                    TextInput::make('uddoktapay_url')->label('UddoktaPay URL')->placeholder('Enter UddoktaPay URL')->url(),
                    TextInput::make('uddoktapay_api_key')->label('UddoktaPay Api Key')->placeholder('Enter UddoktaPay Api Key'),

                ]),
        ];
    }
}
