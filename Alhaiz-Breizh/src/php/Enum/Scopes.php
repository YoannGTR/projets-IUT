<?php

namespace Enum;

enum Scopes: string {
    case LIST_HOUSING = 'Lister les logements';
    case READ_HOUSING_CALENDAR = 'Lire le calendrier des logements';
    case UPDATE_HOUSING_CALENDAR = 'Mettre à jour le calendrier des logements';

    public function getTranslation(): string {
        return $this->value;
    }

    public static function translate(string $activity): string {
        return match($activity) {
            'LIST_HOUSING' => self::LIST_HOUSING->getTranslation(),
            'READ_HOUSING_CALENDAR' => self::READ_HOUSING_CALENDAR->getTranslation(),
            'UPDATE_HOUSING_CALENDAR' => self::UPDATE_HOUSING_CALENDAR->getTranslation(),
            default => 'Aucune permission trouvée'
        };
    }
}