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

class SmsSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.page-setting';

    public $sms_provider;
    public $bulk_sms_bd_api;
    public $bulk_sms_bd_sender_id;
    public $balance_bulksms_bd;
    public $user;
    public $message;



    public function mount()
    {
        $this->form->fill([

            'sms_provider' => getSetting('sms_provider'),
            'bulk_sms_bd_api' => getSetting('bulk_sms_bd_api'),
            'bulk_sms_bd_sender_id' => getSetting('bulk_sms_bd_sender_id'),
            'balance_bulksms_bd' => get_balance_bulksmsbd(),


        ]);
    }
    public function submit()
    {

        setSetting('sms_provider',$this->sms_provider);
        setSetting('bulk_sms_bd_api',$this->bulk_sms_bd_api);
        setSetting('bulk_sms_bd_sender_id',$this->bulk_sms_bd_sender_id);




        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
        if ($this->user && $this->message){
            if ($this->user == 'all'){
                $students = User::all();
                foreach ($students as $student){
                    send_sms($student->phone_number,$this->message,'promotional');
                }
            }else{
                $student = User::find($this->user);
                send_sms($student->phone_number,$this->message,'promotional');
            }
        }
    }
    protected function getFormSchema(): array
    {
        $users = User::all(); // Replace 'User' with your actual User model
        $userOptions = $users->pluck('name', 'id')->prepend('All Students', 'all')->all();

        return [
            Section::make('SMS Settings ')
                ->columns([
                    'sm' => 1,
                    'md' => 2
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('sms_provider')->options(['bulk_sms_bd'=>'BULK SMS BD']),
                    TextInput::make('bulk_sms_bd_api')
                        ->label('Bulk SMS API (bulk_sms_bd_api)')
                        ->placeholder('Enter Bulk SMS API'),
                    TextInput::make('bulk_sms_bd_sender_id')
                        ->label('Bulk SMS Sender ID (bulk_sms_bd_sender_id)')
                        ->placeholder('Enter Bulk SMS Sender ID '),
                    TextInput::make('balance_bulksms_bd')
                        ->label('Bulk SMS Balance')->disabled(),



                ]),
            Section::make('Send SMS')
                ->columns([
                    'sm' => 1,
                ])
                ->collapsed()
                ->schema([
                    \Filament\Forms\Components\Select::make('user')->options($userOptions),
                    \Filament\Forms\Components\Textarea::make('message'),
                ]),


        ];
    }
}
