<?php

namespace Enum;

enum Amenities: string {
    case GARDEN = 'Jardin';
    case BALCONY = 'Balcon';
    case TERRACE = 'Terrasse';
    case POOL = 'Piscine';
    case JACUZZI = 'Jacuzzi';

    public function getTranslation(): string {
        return $this->value;
    }

    public static function translate(string $activity): string {
        return match($activity) {
            'GARDEN' => self::GARDEN->getTranslation(),
            'BALCONY' => self::BALCONY->getTranslation(),
            'TERRACE' => self::TERRACE->getTranslation(),
            'POOL' => self::POOL->getTranslation(),
            'JACUZZI' => self::JACUZZI->getTranslation(),
            default => throw new ValueError("$activity is not a valid activity"),
        };
    }
}