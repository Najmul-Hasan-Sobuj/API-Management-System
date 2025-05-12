<?php

namespace App\Filament\Resources\PayloadResource\Pages;

use App\Filament\Resources\PayloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPayloads extends ListRecords
{
    protected static string $resource = PayloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 