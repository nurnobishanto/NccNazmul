<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseCategoryResource\Pages;
use App\Filament\Resources\CourseCategoryResource\RelationManagers;
use App\Models\CourseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseCategoryResource extends Resource
{
    protected static ?string $model = CourseCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Course Module';
    protected static ?int $navigationSort = 1;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->visibleOn(['edit','view']),
                Forms\Components\TextInput::make('order')
                    ->numeric(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->imageEditor(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('courses_count')->counts('courses')->searchable(),
                Tables\Columns\TextColumn::make('order')->numeric()->sortable(),
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
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListCourseCategories::route('/'),
            'create' => Pages\CreateCourseCategory::route('/create'),
            'edit' => Pages\EditCourseCategory::route('/{record}/edit'),
        ];
    }
}
