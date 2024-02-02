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

class EmailSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.page-setting';

    public $email_mailer;
    public $email_host;
    public $email_port;
    public $email_username;
    public $email_password;
    public $email_encryption;
    public $email_from_email;
    public $email_from_name;
    public $email_contact_to;
    public $user;
    public $subject;
    public $message;


    public function mount()
    {
        $this->form->fill([

            'email_mailer' => env('MAIL_MAILER'),
            'email_host' => env('MAIL_HOST'),
            'email_port' => env('MAIL_PORT'),
            'email_username' => env('MAIL_USERNAME'),
            'email_password' => env('MAIL_PASSWORD'),
            'email_encryption' => env('MAIL_ENCRYPTION'),
            'email_from_email' => env('MAIL_FROM_ADDRESS'),
            'email_from_name' => env('MAIL_FROM_NAME'),
            'email_contact_to' => env('MAIL_CONTACT_MAIL'),

        ]);
    }
    public function submit()
    {
        $envVariablesToUpdate = [
            'MAIL_MAILER' => $this->email_mailer,
            'MAIL_HOST' => $this->email_host,
            'MAIL_PORT' => $this->email_port,
            'MAIL_USERNAME' => $this->email_username,
            'MAIL_PASSWORD' => $this->email_password,
            'MAIL_ENCRYPTION' => $this->email_encryption,
            'MAIL_FROM_ADDRESS' => $this->email_from_email,
            'MAIL_FROM_NAME' => $this->email_from_name,
            'MAIL_CONTACT_MAIL' => $this->email_contact_to,
        ];

        foreach ($envVariablesToUpdate as $key => $value) {
            if (env($key) != $value) { setEnv($key, $value); }
        }



        if ($this->user && $this->message && $this->subject){
            if ($this->user == 'all'){
                $students = User::all();
                foreach ($students as $student){
                    sendPromotionalMail( $student->email,$student->name, $this->subject,$this->message);
                }
            }else{
                $student = User::find($this->user);
                sendPromotionalMail( $student->email,$student->name, $this->subject,$this->message);

            }
        }



    }
    protected function getFormSchema(): array
    {
        $users = User::all(); // Replace 'User' with your actual User model
        $userOptions = $users->pluck('name', 'id')->prepend('All Students', 'all')->all();

        return [
            Section::make('Email Settings ')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('email_mailer')->options(['smtp'=>'SMTP']),
                    TextInput::make('email_host')
                        ->label('Email HOST (email_host)')
                        ->placeholder('Enter Email Host/Server'),

                    TextInput::make('email_port')
                        ->label('Email Port (email_port)')
                        ->placeholder('Enter Email Port '),
                    TextInput::make('email_username')->label('Email username'),
                    TextInput::make('email_password')->label('Email password'),
                    TextInput::make('email_encryption')->label('Email encryption'),
                    TextInput::make('email_from_email')->label('From Email'),
                    TextInput::make('email_from_name')->label('From Name'),
                    TextInput::make('email_contact_to')->label('Contact mail send'),



                ]),
            Section::make('Send Email')
                ->columns([
                    'sm' => 1,
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('user')->options($userOptions),
                    TextInput::make('subject'),
                    Textarea::make('message'),
                ]),


        ];
    }
}
