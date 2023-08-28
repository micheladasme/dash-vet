<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    // funcion para redireccionar a la tabla despues de agregar la información
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
