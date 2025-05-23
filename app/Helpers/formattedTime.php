<?php

declare(strict_types=1);

if (!function_exists('formatTime')) {
    /**
     * 時間をユーザが見やすい形にフォーマット
     * @return string
     */
    function formatTime(string $time): string
    {
        return date('H時i分', strtotime($time));
    }
}
