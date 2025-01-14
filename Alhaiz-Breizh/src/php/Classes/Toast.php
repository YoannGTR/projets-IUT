<?php

namespace Classes;

class Toast
{
    private static $toasts = [];

    public static function trigger($message, $toastType = 'info', $duration = 5000)
    {
        self::$toasts[] = [
            'message' => $message,
            'type' => $toastType,
            'duration' => $duration
        ];
    }

    public static function storeToastForNextPage($message, $toastType = 'info', $duration = 5000)
    {
        $_SESSION['toast'] = [
            'message' => $message,
            'type' => $toastType,
            'duration' => $duration
        ];
    }

    public static function triggerStoredToast()
    {
        if (isset($_SESSION['toast'])) {
            self::trigger($_SESSION['toast']['message'], $_SESSION['toast']['type'], $_SESSION['toast']['duration']);
            unset($_SESSION['toast']);
        }
    }

    public static function getToasts()
    {
        return self::$toasts;
    }

    public static function clearToasts()
    {
        self::$toasts = [];
    }
}