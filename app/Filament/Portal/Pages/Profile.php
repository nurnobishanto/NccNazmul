<?php

namespace App\Filament\Portal\Pages;

use App\Models\Batch;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Profile extends Page
{

    protected static string $view = 'filament.portal.pages.profile';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Profile';
    protected static ?int $navigationSort = 1;

    public $user_id;
    public $name;
    public $email;
    public $phone_number;
    public $gender;
    public $batch;
    public $college;

    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $division_id;
    public $district_id;
    public $upazila;
    public $postCode;
    public $postOffice;



    public function mount()
    {
        $this->form->fill([
            'user_id' => auth()->user()->user_id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone_number' => auth()->user()->phone_number,
            'gender' => auth()->user()->gender,
            'batch' => auth()->user()->batch,
            'college' => auth()->user()->college,
            'division_id' => auth()->user()->division_id,
            'district_id' => auth()->user()->district_id,
            'upazila' => auth()->user()->upazila,
            'postOffice' => auth()->user()->postOffice,
            'postCode' => auth()->user()->postCode,

        ]);
    }
    public function submit()
    {


        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'phone_number' => [
                'required',
                'string',
                'unique:users,phone_number,' . auth()->id(),
            ],
            'new_password' => 'nullable|string|min:8|confirmed',
        ];

        // Add validation rule for current_password only if new_password is not null
        if ($this->new_password !== null) {
            $rules['current_password'] = 'required|string|min:8';
        }

        $this->validate($rules);
        $data = array_filter([
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,

            'batch' => $this->batch,
            'college' => $this->college,
            'division_id' => $this->division_id,
            'district_id' => $this->district_id,
            'upazila' => $this->upazila,
            'postCode' => $this->postCode,
            'postOffice' => $this->postOffice,
            'password' => $this->new_password ? Hash::make($this->new_password) : null,
        ]);

        $user = auth()->user();

        $user->update($data);

        if ($this->new_password) {
            $this->updateSessionPassword($user);
        }

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
    protected function updateSessionPassword($user)
    {
        request()->session()->put([
            'password_hash_' . auth()->getDefaultDriver() => $user->getAuthPassword(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('General')
                ->columns(2)
                ->schema([
                    TextInput::make('user_id')
                        ->required()
                        ->disabled()
                        ->label('User ID'),
                    TextInput::make('name')
                        ->label('Full Name')
                        ->placeholder('Enter Full Name')
                        ->required(),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->placeholder('Enter Valid Email Address')
                        ->unique('users,email')
                        ->email(),
                    TextInput::make('phone_number')
                        ->label('Phone Number Address')
                        ->placeholder('Enter Valid Phone number')
                        ->required()
                        ->unique('users,phone_number')
                        ->tel(),
                    Select::make('gender')->label('Select Gender')
                        ->options(['male' => 'Male','female' => 'Female'])->required(),
                    Select::make('batch')
                        ->label('Select Batch')
                        ->options(Batch::all()->pluck('name','id'))
                        ->placeholder('Optional'),
                    TextInput::make('college')
                        ->label('College')
                        ->placeholder('Optional'),
                    Select::make('division_id')
                        ->label('Select Division')
                        ->searchable()
                        ->options(getDivisionOptions())
                        ->reactive(),

                    Select::make('district_id')
                        ->label('Select District')
                        ->reactive()
                        ->options(function (callable $get, callable $set) {
                            return getDistrictOptions($get('division_id'));
                        }),
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

                ]),
            Section::make('Update Password')
                ->columns(2)
                ->schema([
                    TextInput::make('current_password')
                        ->label('Current Password')
                        ->password()
                        ->revealable(filament()->arePasswordsRevealable())
                        ->rules(['required_with:new_password'])
                        ->currentPassword()
                        ->autocomplete('off')
                        ->columnSpan(1),
                    Grid::make()
                        ->schema([
                            TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->revealable(filament()->arePasswordsRevealable())
                                ->rules(['confirmed'])
                                ->autocomplete('new-password'),
                            TextInput::make('new_password_confirmation')
                                ->label('Confirm Password')
                                ->password()
                                ->revealable(filament()->arePasswordsRevealable())
                                ->rules([
                                    'required_with:new_password',
                                ])
                                ->autocomplete('new-password'),
                        ]),
                ]),

        ];
    }

}
