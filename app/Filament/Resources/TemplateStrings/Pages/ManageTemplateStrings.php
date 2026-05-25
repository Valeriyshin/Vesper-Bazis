<?php

namespace App\Filament\Resources\TemplateStrings\Pages;

use App\Filament\Resources\TemplateStrings\TemplateStringResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTemplateStrings extends ManageRecords
{
    protected static string $resource = TemplateStringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
