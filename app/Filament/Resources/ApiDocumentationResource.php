<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiDocumentationResource\Pages;
use App\Models\Endpoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiDocumentationResource extends Resource
{
    protected static ?string $model = Endpoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'API Management';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'API Documentation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('group_id')
                    ->relationship('group', 'name')
                    ->nullable()
                    ->label('Filter by Group'),
                Forms\Components\Select::make('collection_id')
                    ->relationship('collection', 'name')
                    ->nullable()
                    ->label('Filter by Collection'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->sortable()
                    ->label('Group'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('method.method')
                    ->sortable(),
                Tables\Columns\TextColumn::make('collection.name')
                    ->sortable(),
            ])
            ->groups([
                Tables\Grouping\Group::make('group.name')
                    ->label('Group')
                    ->collapsible(),
            ])
            ->defaultGroup('group.name')
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->relationship('group', 'name'),
                Tables\Filters\SelectFilter::make('collection')
                    ->relationship('collection', 'name'),
                Tables\Filters\SelectFilter::make('method')
                    ->relationship('method', 'method'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_documentation')
                    ->label('View Documentation')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Endpoint $record): string => route('api.documentation.show', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListApiDocumentation::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['method', 'collection', 'group', 'headers', 'payloads'])
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
} 