<?php

namespace App\Filament\Portal\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BaseReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class RequestPasswordReset extends BaseReset
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //$this->getEmailFormComponent(),
                $this->getLoginFormComponent(),

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
    public function request(): void
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/password-reset/request-password-reset.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return;
        }
        $data = $this->form->getState();
        $loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($data['login']) && strlen($data['login']) < 9 ? 'user_id' : 'phone_number');

        $loginData = $data['login'];
        if ($loginType == 'phone_number'){
            $loginData = number_validation($data['login']);
        }
        $user = User::where($loginType,$loginData)->first();
        if (!$user){
            Notification::make()
                ->title('User not found!')
                ->danger()
                ->send();
                
        }
        if ($loginType == 'email' && $user){
            $status = Password::broker(Filament::getAuthPasswordBroker())->sendResetLink(
                $data,
                function (CanResetPassword $user, string $token): void {
                    if (! method_exists($user, 'notify')) {
                        $userClass = $user::class;

                        throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
                    }

                    $notification = new ResetPasswordNotification($token);
                    $notification->url = Filament::getResetPasswordUrl($token, $user);

                    $user->notify($notification);
                },
            );

            if ($status !== Password::RESET_LINK_SENT) {
                Notification::make()
                    ->title(__($status))
                    ->danger()
                    ->send();

                return;
            }

            Notification::make()
                ->title(__($status))
                ->success()
                ->send();

            $this->form->fill();
        }
        else{
            $genPass = 'NCC'.rand(1000,9999).'#';
            $user->password = Hash::make($genPass);
            $user->update();
            $subject = "Reset password";
            $body = "NCCC, আপনার ইউজার আইডি :".$user->user_id." এবং  নতুন পাসওয়ার্ড : "."<strong>".$genPass."</strong>";
            if ($user->email){
                sendPromotionalMail( $user->email,$user->name, $subject,$body);
                Notification::make()
                    ->title('Password sent to your email address')
                    ->success()
                    ->send();
            }
            if ($user->phone_number){
                send_sms($user->phone_number,$body,'Password Reset');
                Notification::make()
                    ->title('Password sent to your phone number')
                    ->success()
                    ->send();
            }
        }
    }
}
