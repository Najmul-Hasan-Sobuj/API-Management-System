<?php

namespace App\Filament\Resources\TemplatePageResource\Pages;

use App\Filament\Resources\TemplatePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemplatePages extends ListRecords
{
    protected static string $resource = TemplatePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 