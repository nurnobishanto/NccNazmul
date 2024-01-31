<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseItemResource\Pages;
use App\Filament\Resources\CourseItemResource\RelationManagers;
use App\Models\Course;
use App\Models\CourseItem;
use App\Models\CourseModule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class CourseItemResource extends Resource
{
    protected static ?string $model = CourseItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Course Module';
    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->columnSpanFull(),

                Forms\Components\Select::make('course_id')
                    ->options(Course::query()->pluck('title', 'id'))
                    ->live(),
                Forms\Components\Select::make('course_module_id')
                    ->options(fn (Get $get): Collection => CourseModule::query()
                        ->where('course_id', $get('course_id'))
                        ->pluck('title', 'id')),

//                Forms\Components\Select::make('course_module_id')
//                    ->required()
//                    ->relationship('module','title'),
                Forms\Components\RichEditor::make('details')->columnSpanFull(),
                Forms\Components\FileUpload::make('image')->image()->imageEditor(),
                Forms\Components\FileUpload::make('pdf')->acceptedFileTypes(['pdf']),
//                Forms\Components\FileUpload::make('video'),
//                Forms\Components\FileUpload::make('file'),
                Forms\Components\Select::make('exam_paper_id')->relationship('exam_paper','name'),
                Forms\Components\TextInput::make('youtube_video'),
                Forms\Components\TextInput::make('url')->url()->label('Custom URL'),
                Forms\Components\TextInput::make('youtube_playlist')->url(),

                Forms\Components\Select::make('status')->options(['draft' => 'DRAFT', 'published' => 'PUBLISHED'])->required()->default('published'),
                Forms\Components\DatePicker::make('published_at')->default(today()),
                Forms\Components\TextInput::make('order')->numeric()->default(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module.course.title')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('module.title')->numeric()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('order')->numeric()->sortable(),
                Tables\Columns\SelectColumn::make('status')->options(['draft' => 'DRAFT', 'published' => 'PUBLISHED'])->disabled(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('module.course', 'title'),
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
            'index' => Pages\ListCourseItems::route('/'),
            'create' => Pages\CreateCourseItem::route('/create'),
            'edit' => Pages\EditCourseItem::route('/{record}/edit'),
        ];
    }
}
