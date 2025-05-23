<?php

declare(strict_types=1);

if (!function_exists('formattedDate')) {
    /**
     * 時間をユーザが見やすい形にフォーマット
     * @return string
     */
    function formatDate(string $date): string
    {
        return date('Y年m月d日', strtotime($date));
    }
}
