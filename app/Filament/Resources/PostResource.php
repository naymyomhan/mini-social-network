<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\ReactRelationManager;
use App\Models\Post;
use App\Models\Topic;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\FontWeight;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->columnSpan('full'),
                MarkdownEditor::make('body')->columnSpan('full'),
                DateTimePicker::make('created_at'),
                Select::make('topic_id')
                    ->label('Topic')
                    ->options(Topic::all()->pluck('topic', 'id'))
                    ->searchable(),
                SpatieMediaLibraryFileUpload::make('images')->collection('post_images')->multiple()->columnSpan('full'),
            ])->columns(2);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('created_at')->size(TextEntry\TextEntrySize::ExtraSmall)->dateTime()->label(''),
                TextEntry::make('title')->size(TextEntry\TextEntrySize::Large)->weight(FontWeight::Bold)->label(''),
                TextEntry::make('topic.topic')->color('info')->badge()->label(''),
                TextEntry::make('body')->label(''),
                SpatieMediaLibraryImageEntry::make('images')->collection('post_images')->label(''),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('title')->limit(50),
                TextColumn::make('topic.topic')->color('info')->badge(),
                // ImageColumn::make('images')->disk('minio'),
                // SpatieMediaLibraryImageColumn::make('images')->collection('post_images'),
                TextColumn::make('react_count'),
                TextColumn::make('comment_count'),
                TextColumn::Make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            CommentsRelationManager::class,
            ReactRelationManager::class,
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
}
