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
        $loginType = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($data['login']) && strlen($data['login']) === 9 ? 'user_id' : 'phone_number');
        $user = User::where($loginType,$data['login'])->first();
        if (!$user){
            Notification::make()
                ->title('User not found!')
                ->danger()
                ->send();
        }
        if ($loginType == 'email'){
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
        }else{
            Notification::make()
                ->title('Password sent via sms')
                ->success()
                ->send();
        }
    }
}
