<?php

function public_asset($path)
{
    if (config('app.env') == 'production') {
        return url('public/' . ltrim($path, '/'));
    } else {
        return asset($path);
    }
}