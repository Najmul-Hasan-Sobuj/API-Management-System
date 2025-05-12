<?php

namespace App\Filament\Resources\TemplateResource\Pages;

use App\Filament\Resources\TemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PreviewTemplate extends ViewRecord
{
    protected static string $resource = TemplateResource::class;

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
                Infolists\Components\Section::make('Template Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('slug'),
                        Infolists\Components\TextEntry::make('description')
                            ->html()
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('is_active')
                            ->badge()
                            ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Inactive'),
                    ])->columns(2),

                Infolists\Components\Section::make('Fields')
                    ->schema(function () {
                        $fields = [];
                        $templateFields = $this->record->fields ?? [];
                        
                        foreach ($templateFields as $field) {
                            $fields[] = Infolists\Components\TextEntry::make("field_{$field['name']}")
                                ->label($field['label'])
                                ->formatStateUsing(function () use ($field) {
                                    $info = [
                                        'Type' => $field['type'],
                                        'Required' => $field['required'] ? 'Yes' : 'No',
                                    ];

                                    if (isset($field['options'])) {
                                        $info['Options'] = $field['options'];
                                    }

                                    if (isset($field['min'])) {
                                        $info['Min Length'] = $field['min'];
                                    }

                                    if (isset($field['max'])) {
                                        $info['Max Length'] = $field['max'];
                                    }

                                    return collect($info)
                                        ->map(fn ($value, $key) => "{$key}: {$value}")
                                        ->join("\n");
                                })
                                ->html();
                        }
                        
                        return $fields;
                    }),
            ]);
    }
} 