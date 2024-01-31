<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\MyCourseResource\Pages;
use App\Filament\Portal\Resources\MyCourseResource\RelationManagers;
use App\Models\Course;
use App\Models\ExamPaper;
use App\Models\MyCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MyCourseResource extends Resource
{
    protected static ?string $model = "My Course";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('modules_count')->counts('modules'),
                Tables\Columns\TextColumn::make('items_count')->counts('items'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),

                Action::make('learn')
                    ->label('Learn Now')
                    ->url(fn (Course $record): string => route('learn',['slug'=>$record->slug] )),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => Pages\ListMyCourses::route('/'),
            //'create' => Pages\CreateMyCourse::route('/create'),
            //'edit' => Pages\EditMyCourse::route('/{record}/edit'),
        ];
    }
}
