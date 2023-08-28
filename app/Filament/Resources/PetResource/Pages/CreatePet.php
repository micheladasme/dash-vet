<?php

namespace App\Filament\Resources\PetResource\Pages;

use App\Filament\Resources\PetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePet extends CreateRecord
{
    protected static string $resource = PetResource::class;

    // funcion para redireccionar a la tabla despues de editar la información
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
