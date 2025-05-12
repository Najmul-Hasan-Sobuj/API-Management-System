<?php

namespace App\Filament\Resources\TemplatePageResource\Pages;

use App\Filament\Resources\TemplatePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PreviewTemplatePage extends ViewRecord
{
    protected static string $resource = TemplatePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Page Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('title'),
                        Infolists\Components\TextEntry::make('slug'),
                        Infolists\Components\TextEntry::make('content')
                            ->html()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('is_published')
                            ->badge()
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Published' : 'Draft'),
                        Infolists\Components\TextEntry::make('published_at')
                            ->dateTime(),
                    ])->columns(2),

                Infolists\Components\Section::make('Dynamic Fields')
                    ->schema(function () {
                        $fields = [];
                        $data = $this->record->data ?? [];
                        
                        foreach ($data as $key => $value) {
                            $fields[] = Infolists\Components\TextEntry::make("data.{$key}")
                                ->label(ucfirst(str_replace('_', ' ', $key)))
                                ->formatStateUsing(function ($state) {
                                    if (is_array($state)) {
                                        return json_encode($state, JSON_PRETTY_PRINT);
                                    }
                                    return $state;
                                });
                        }
                        
                        return $fields;
                    }),
            ]);
    }
} 