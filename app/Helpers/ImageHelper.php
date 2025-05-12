<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function getImage(?string $path, string $alt = ''): string
    {
        // If path is null or empty, return placeholder
        if (empty($path)) {
            return "https://placehold.co/600x400?text=" . urlencode($alt);
        }

        // Check if file exists in storage
        if (!Storage::exists($path)) {
            return "https://placehold.co/600x400?text=" . urlencode($alt);
        }

        // Return actual image URL
        return Storage::url($path);
    }
} 