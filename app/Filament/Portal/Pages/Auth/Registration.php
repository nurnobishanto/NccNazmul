<?php

namespace App\Filament\Portal\Pages\Auth;

use App\Models\Batch;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseAuth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class Registration extends BaseAuth
{

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getRegisterFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getConfirmPasswordFormComponent(),
                $this->getCollegeFormComponent(),
                Select::make('gender')->label('Select Gender')
                    ->options(['male' => 'Male','female' => 'Female'])->required(),
                $this->getBatchFormComponent(),
                $this->getDivisionFormComponent(),
                $this->getDistrictFormComponent(),
                Select::make('upazila')
                    ->label('Select Upazila')
                    ->reactive()
                    ->options(function (callable $get, callable $set) {
                        return getUpazila($get('district_id'));
                    }),
                Select::make('postOffice')
                    ->label('Select post Office')
                    ->reactive()
                    ->options(function (callable $get, callable $set) {
                        return getPostOffices($get('upazila'));
                    }),
                Select::make('postCode')
                    ->label('Select post Code')
                    ->reactive()
                    ->options(function (callable $get, callable $set) {
                        return getPostCodes($get('upazila'));
                    }),
            ])
            ->columns([
                'default' => 1,
                'sm' => 2,
                'md' => 2,
                'lg' => 2,
                'xl' => 2,
                '2xl' => 2,
            ])
            ->statePath('data');
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Full name')
            ->placeholder("Enter your full name")
            ->required()->columnSpan(2);
    }
    protected function getRegisterFormComponent(): Component
    {
        return TextInput::make('register')
            ->label('Phone Number')
            ->placeholder("Enter Phone Number")
            ->tel()
            ->required()
            ->autocomplete()->columnSpan(2)
            ->autofocus();
    }
    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->placeholder("Enter password")
            ->autocomplete()->columnSpan(2)
            ->revealable(filament()->arePasswordsRevealable())
            ->password()
            ->required()
            ->rule(\Illuminate\Validation\Rules\Password::default())
            
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }
    protected function getConfirmPasswordFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label('Confirm Password')
            ->placeholder("Enter Confirm password")
            ->autocomplete()->columnSpan(2)
            ->revealable(filament()->arePasswordsRevealable())
            ->password()
            ->required()
            ->dehydrated(false);
    }
    protected function getBatchFormComponent(): Component
    {
        return Select::make('batch')
            ->label('Select Batch')
            ->options(Batch::all()->pluck('name','id'))
            ->placeholder('Optional');
    }
    protected function getCollegeFormComponent(): Component
    {
        return TextInput::make('college')
            ->label('College')
            ->placeholder('Optional')->columnSpan(2);
    }
    protected function getDivisionFormComponent(): Component
    {
        return
            Select::make('division_id')
                ->label('Select Division')
                ->searchable()
                ->options(getDivisionOptions())
                ->reactive()->columnSpanFull();
    }
    protected function getDistrictFormComponent(): Component
    {
        return
            Select::make('district_id')
                ->label('Select District')
                ->reactive()
                ->options(function (callable $get, callable $set) {
                    return getDistrictOptions($get('division_id'));
                });

    }
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }
        $data = $this->form->getState();
      
        $loginType = $this->detectLoginType($data['register']);
        $validationStatus = true;
        $loginData = $data['register'];
        if ($loginType == 'phone_number'){
            
            $loginData = (number_validation($data['register']));
            if (!$loginData){
                $validationStatus = false;
                Notification::make()
                    ->title('Invalid Phone Number')
                    ->danger()
                    ->send();
            }
        }
        $oldUser = User::where($loginType,$loginData)->first();
        if ($oldUser){
            Notification::make()
                ->title('Already registered')
                ->danger()
                ->send();
        }
        else if($validationStatus){
            $newData = [
                'name'            => $data['name'],
                $loginType        => $loginData,
                'password'        => Hash::make($data['password']),
                'gender'          => $data['gender'] ?? null,
                'batch'           => $data['batch'] ?? null,
                'college'         => $data['college'] ?? null,
                'division_id'     => $data['division_id'] ?? null,
                'district_id'     => $data['district_id'] ?? null,
                'upazila'         => $data['upazila'] ?? null,
                'postOffice'      => $data['postOffice'] ?? null,
                'postCode'        => $data['postCode'] ?? null,
            ];
            $user = $this->getUserModel()::create($newData);
            $subject = "আপনার অ্যাকাউন্ট তৈরি করা হয়েছ ";
            $body  = "NCCC তে আপনার ইউজার আইডি : ".$user->user_id." এবং পাসওয়ার্ড: ". $data['password'];
             if ($user->email){
                sendPromotionalMail( $user->email,$user->name, $subject,$body);
            }
            if ($user->phone_number){
                send_sms($user->phone_number,$body,$subject);
            }
            app()->bind(
                \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
            // \Filament\Listeners\Auth\SendEmailVerificationNotification::class,
            );
            event(new Registered($user));

            Filament::auth()->login($user);

            session()->regenerate();

            return app(RegistrationResponse::class);
        }
        return app(RegistrationResponse::class);
    }
    protected function detectLoginType(string $register): string
    {
        return filter_var($register, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';
    }
}
