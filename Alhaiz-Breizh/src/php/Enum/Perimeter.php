<?php

namespace Enum;

enum Perimeter: string {
    case ON_THE_SPOT = 'Sur place';
    case LESS_5_KM = 'Moins de 5 km';
    case LESS_10_KM = 'Moins de 10 km';
    case LESS_20_KM = 'Moins de 20 km';
    case MORE_20_KM = 'Plus de 20 km';

    public function getTranslation(): string {
        return $this->value;
    }

    public static function translate(string $activity): string {
        return match($activity) {
            'ON_THE_SPOT' => self::ON_THE_SPOT->getTranslation(),
            'LESS_5_KM' => self::LESS_5_KM->getTranslation(),
            'LESS_10_KM' => self::LESS_10_KM->getTranslation(),
            'LESS_20_KM' => self::LESS_20_KM->getTranslation(),
            'MORE_20_KM' => self::MORE_20_KM->getTranslation(),
            default => throw new ValueError("$activity is not a valid activity"),
        };
    }
}