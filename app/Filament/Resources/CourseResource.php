<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Course Module';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()->columnSpanFull()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->visibleOn(['edit','view']),
                Forms\Components\Select::make('course_category_id')->relationship('category','title')->required(),
                Forms\Components\TextInput::make('regular_price')->numeric()->required(),
                Forms\Components\TextInput::make('sale_price')->numeric()->required(),
                Forms\Components\TextInput::make('order')->numeric(),
                Forms\Components\Select::make('status')->options(['draft' => 'DRAFT', 'published' => 'PUBLISHED'])->required(),
                Forms\Components\TextInput::make('duration'),
                Forms\Components\RichEditor::make('details')->columnSpanFull(),
                Forms\Components\FileUpload::make('image')->image()->imageEditor()->required()->imageCropAspectRatio('16:9'),
                Forms\Components\TextInput::make('meet_link')->url(),
                Forms\Components\TextInput::make('whatsapp_group_link')->url(),
                Forms\Components\TextInput::make('facebook_group')->url(),
                Forms\Components\TextInput::make('zoom_link')->url(),
                Forms\Components\TextInput::make('youtube_playlist')->url(),
                Forms\Components\DatePicker::make('publish_date'),
                Forms\Components\DatePicker::make('start_date'),
                Forms\Components\DatePicker::make('end_date'),
                Forms\Components\DatePicker::make('expired_date'),
                Forms\Components\Radio::make('lifetime_access')->options([false => 'Date Wise Access',true => 'Lifetime Access'])->default(0)->label('Access Type'),
                Forms\Components\Radio::make('featured')->options([false => 'Normal Course',true => 'Featured Course'])->default(0)->label('Is Featured ?'),
                Forms\Components\Select::make('teachers')->relationship('teachers','name')->multiple()->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('category.title')->searchable(),
                Tables\Columns\TextColumn::make('order')->numeric()->sortable(),
                Tables\Columns\BooleanColumn::make('lifetime_access'),
                Tables\Columns\BooleanColumn::make('featured'),
                Tables\Columns\TextColumn::make('users_count')->counts('users')->label('Students'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('category')->relationship('category','title'),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
