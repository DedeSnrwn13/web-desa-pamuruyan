<?php

function public_asset($path)
{
    if (config('app.env') === 'production') {
        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return url('public/' . ltrim($path, '/'));
    }

    return asset($path);
}