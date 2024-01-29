<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Batch;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Full Name')
                    ->placeholder('Enter Full name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->disabled()
                    ->visibleOn(['edit','view'])
                    ->label('User ID')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()->unique(ignoreRecord: true)
                    ->label('Email Address')
                    ->placeholder('Enter Email Address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()->required()
                    ->label('Mobile Number')
                    ->placeholder('Enter Mobile Number')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('password')
                    ->placeholder('Enter strong password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static function ($state) use ($form) {
                        return !empty($state) ? Hash::make($state) : null;
                        $user = User::find($form->getColumns());
                        return $user ? $user->password : null;
                    })->visibleOn('edit'),
                TextInput::make('password')
                    ->placeholder('Enter strong password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static function ($state) use ($form) {
                        return !empty($state) ? Hash::make($state) : null;
                        $user = User::find($form->getColumns());
                        return $user ? $user->password : null;
                    })->visibleOn('create')->required(),
                Forms\Components\TextInput::make('college')
                    ->label('College Name')
                    ->placeholder('Enter Your College Name')
                    ->maxLength(255),
                Select::make('batch')
                    ->options(Batch::pluck('name'))
                    ->label('Select your batch'),
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
                Forms\Components\FileUpload::make('image')->image(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('college')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('batch')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
