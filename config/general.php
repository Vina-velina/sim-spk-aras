<?php

/**
 * Created by Deyan Ardi 2022.
 * API Services Configuration connect to http://sv1.notif.ganadev.com.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | API Notification
    |--------------------------------------------------------------------------
    */
    'api_url' => env('API_URL', 'http://sv1.notif.ganadev.com'),
    'api_token' => env('API_TOKEN', 'Ganadev-122da2c8-6b73-4804-8ce5-7f0c197ad298'),

    /*
    |--------------------------------------------------------------------------
    | APP Asset
    |--------------------------------------------------------------------------
    */
    'icon' => env('GENERAL_ICON', ''),
    'icon-text' => env('GENERAL_ICON_TEXT', ''),
    'icon-text-white' => env('GENERAL_ICON_TEXT_WHITE', ''),
    'fav' => env('GENERAL_FAV', ''),
];
