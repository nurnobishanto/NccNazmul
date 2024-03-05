<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseEnrolledResource\Pages;
use App\Filament\Resources\CourseEnrolledResource\RelationManagers;
use App\Models\Course;
use App\Models\CourseEnrolled;
use App\Models\CourseUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mpdf\Tag\Select;
use App\Models\User;
class CourseEnrolledResource extends Resource
{
    protected static ?string $model = CourseUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Course Enrolled';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')->relationship('course','title')->required(),
               // Forms\Components\Select::make('user_id')->relationship('user','name',fn (Builder $query) => $query->withTrashed())->required()->searchable(),
                
Forms\Components\Select::make('user_id')

    ->options(User::pluck('name', 'id')->map(function ($name, $id) {
        return User::find($id)->user_id . ' - ' . $name;
    })->toArray()) // Assuming 'User' is your Eloquent model
    ->required()
    ->searchable(),
                
                Forms\Components\DatePicker::make('access_expiry'),
                Forms\Components\Radio::make('lifetime_access')->options([false => 'Limited Access',true => 'Lifetime Access'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')->label('Course'),
                Tables\Columns\TextColumn::make('user.name')->label('Student'),
                Tables\Columns\TextColumn::make('access_expiry'),
                Tables\Columns\BooleanColumn::make('lifetime_access'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCourseEnrolleds::route('/'),
            'create' => Pages\CreateCourseEnrolled::route('/create'),
            'edit' => Pages\EditCourseEnrolled::route('/{record}/edit'),
        ];
    }
}
