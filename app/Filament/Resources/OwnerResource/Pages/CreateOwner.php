<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    // funcion para redireccionar a la tabla despues de editar la información
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
