<?php

namespace App\Filament\Resources\FamilyClubs\Pages;

use App\Filament\Resources\FamilyClubs\FamilyClubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageFamilyClubs extends ManageRecords
{
    protected static string $resource = FamilyClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
