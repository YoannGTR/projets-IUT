<?php

namespace Enum;

enum Activity: string {
    case BATHING = 'Baignade';
    case SAIL = 'Voile';
    case CANOE = 'Canoë';
    case GOLF = 'Golf';
    case HORSE_RIDING = 'Équitation';
    case HIKING = 'Randonnée';
    case TREE_CLIMBING = 'Accrobranche';

    public function getTranslation(): string {
        return $this->value;
    }

    public static function translate(string $activity): string {
        return match($activity) {
            'BATHING' => self::BATHING->getTranslation(),
            'SAIL' => self::SAIL->getTranslation(),
            'CANOE' => self::CANOE->getTranslation(),
            'GOLF' => self::GOLF->getTranslation(),
            'HORSE_RIDING' => self::HORSE_RIDING->getTranslation(),
            'HIKING' => self::HIKING->getTranslation(),
            'TREE_CLIMBING' => self::TREE_CLIMBING->getTranslation(),
            default => throw new ValueError("$activity is not a valid activity"),
        };
    }
}