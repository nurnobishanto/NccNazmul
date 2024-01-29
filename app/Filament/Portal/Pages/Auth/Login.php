<?php
namespace App\Filament\Portal\Pages\Auth;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseAuth;

class Login extends BaseAuth
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //$this->getEmailFormComponent(),
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email, User ID, or Phone Number')
            ->required()
            ->autocomplete()
            ->autofocus();
    }
    protected function getCredentialsFromFormData(array $data): array
    {
        $loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($data['login']) && strlen($data['login']) === 9 ? 'user_id' : 'phone_number');
        $user = User::where($loginType,$data['login'])->first();
        if (!$user){
            Notification::make()
                ->title('User not found!')
                ->danger()
                ->send();
        }elseif (!password_verify($data['password'], $user->password)){
            Notification::make()
                ->title('Wrong password')
                ->danger()
                ->send();
        }
        return [
            $loginType => $data['login'],
            'password'  => $data['password'],
        ];
    }
}
