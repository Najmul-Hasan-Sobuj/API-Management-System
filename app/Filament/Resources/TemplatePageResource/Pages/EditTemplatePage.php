<?php

namespace App\Filament\Resources\TemplatePageResource\Pages;

use App\Filament\Resources\TemplatePageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTemplatePage extends EditRecord
{
    protected static string $resource = TemplatePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 