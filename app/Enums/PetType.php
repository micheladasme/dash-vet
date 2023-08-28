<?php
namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum PetType: string implements HasLabel{
    case Dog = 'dog';
    case Cat = 'cat';
    case Rat = 'rat';

    public function getLabel(): ?string
    {
        return match($this){
            self::Dog => 'Dog',
            self::Cat => 'Cat',
            self::Rat => 'Rat',
        };
    }
}

?>