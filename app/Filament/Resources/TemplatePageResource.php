<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplatePageResource\Pages;
use App\Models\TemplatePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class TemplatePageResource extends Resource
{
    protected static ?string $model = TemplatePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->schema([
                        Forms\Components\Select::make('template_id')
                            ->relationship('template', 'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => 
                                $set('fields', [])
                            ),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->default(false),
                                Forms\Components\DateTimePicker::make('published_at')
                                    ->visible(fn (Forms\Get $get) => $get('is_published')),
                            ]),
                    ]),

                Forms\Components\Section::make('Dynamic Fields')
                    ->schema([
                        Forms\Components\Placeholder::make('dynamic_fields')
                            ->content(function (Forms\Get $get) {
                                $template = \App\Models\Template::find($get('template_id'));
                                if (!$template) return 'Select a template to see its fields.';

                                $fields = collect($template->fields)->map(function ($field) {
                                    return match($field['type']) {
                                        'text' => Forms\Components\TextInput::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->when(isset($field['min']), fn ($component) => $component->minLength($field['min']))
                                            ->when(isset($field['max']), fn ($component) => $component->maxLength($field['max']))
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'textarea' => Forms\Components\Textarea::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->when(isset($field['min']), fn ($component) => $component->minLength($field['min']))
                                            ->when(isset($field['max']), fn ($component) => $component->maxLength($field['max']))
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'rich-text' => Forms\Components\RichEditor::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'image' => Forms\Components\FileUpload::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->image()
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'file' => Forms\Components\FileUpload::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'select' => Forms\Components\Select::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->options(collect(explode(',', $field['options'] ?? ''))->mapWithKeys(fn ($option) => [$option => $option]))
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'checkbox' => Forms\Components\Checkbox::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'radio' => Forms\Components\Radio::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->options(collect(explode(',', $field['options'] ?? ''))->mapWithKeys(fn ($option) => [$option => $option]))
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'date' => Forms\Components\DatePicker::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'datetime' => Forms\Components\DateTimePicker::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'number' => Forms\Components\TextInput::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->numeric()
                                            ->required($field['required'] ?? false)
                                            ->when(isset($field['min']), fn ($component) => $component->minValue($field['min']))
                                            ->when(isset($field['max']), fn ($component) => $component->maxValue($field['max']))
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'email' => Forms\Components\TextInput::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->email()
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'url' => Forms\Components\TextInput::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->url()
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'color' => Forms\Components\ColorPicker::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        'time' => Forms\Components\TimePicker::make("data.{$field['name']}")
                                            ->label($field['label'])
                                            ->required($field['required'] ?? false)
                                            ->default($field['default'] ?? null)
                                            ->helperText($field['help_text'] ?? null)
                                            ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state) : $state)
                                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? json_decode($state, true) : $state),
                                        default => null,
                                    };
                                })->filter()->toArray();

                                return $fields;
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('template.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return '-';
                        return collect($state)->map(function ($value, $key) {
                            if (is_array($value)) {
                                return $key . ': ' . json_encode($value);
                            }
                            return $key . ': ' . $value;
                        })->join(', ');
                    })
                    ->wrap()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('template')
                    ->relationship('template', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueLabel('Published pages')
                    ->falseLabel('Draft pages')
                    ->placeholder('All pages'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('preview')
                    ->icon('heroicon-o-eye')
                    ->url(fn (TemplatePage $record): string => TemplatePageResource::getUrl('preview', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->icon('heroicon-o-check')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update([
                            'is_published' => true,
                            'published_at' => now(),
                        ])),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->icon('heroicon-o-x-mark')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update([
                            'is_published' => false,
                            'published_at' => null,
                        ])),
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
            'index' => Pages\ListTemplatePages::route('/'),
            'create' => Pages\CreateTemplatePage::route('/create'),
            'edit' => Pages\EditTemplatePage::route('/{record}/edit'),
            'preview' => Pages\PreviewTemplatePage::route('/{record}/preview'),
        ];
    }
} 