<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->relationship('user','name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category','name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Enter Post title')
                    ->maxLength(255),
                TextInput::make('slug')->unique(ignoreRecord: true)->visibleOn(['edit','view']),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'DRAFT',
                        'published' => 'PUBLISHED',
                    ])
                    ->default('draft'),

                Forms\Components\RichEditor::make('body')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image(),

                Forms\Components\Textarea::make('excerpt')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('meta_description')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('meta_keywords')
                    ->maxLength(65535),
                Forms\Components\Toggle::make('featured')
                    ->required(),
                Forms\Components\TextInput::make('seo_title')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('seo_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
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
