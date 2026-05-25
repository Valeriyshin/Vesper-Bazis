<?php

namespace App\Filament\Resources\ProgressStages\Pages;

use App\Filament\Resources\ProgressStages\ProgressStageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProgressStages extends ManageRecords
{
    protected static string $resource = ProgressStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
