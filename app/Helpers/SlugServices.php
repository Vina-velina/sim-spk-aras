<?php

namespace App\Helpers;

/**
 * Created by Deyan Ardi 2022.
 * Slug Generator
 */
class SlugServices
{
    public static function create($title, $length = 12)
    {
        $slug = '';
        if (! empty($title)) {
            $res = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $title);
            $cut = self::cutString($res);
            $random = self::generateRandomText($length);
            $slug = $cut.'-'.$random;
        }

        return $slug;
    }

    public static function cutString(string $text)
    {
        $explode = explode(' ', strtolower($text));
        $string = '';
        foreach ($explode as $index => $item) {
            if ($index == 0) {
                $string = $item;
            } else {
                if ($item != '') {
                    $string .= '-'.$item;
                } else {
                    $string .= $item;
                }
            }
        }

        return $string;
    }

    public static function generateRandomText($length)
    {
        $key = '0123456789abcdefghijklmnopqrstuvwxyz';
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($key) - 1);
            $random .= $key[$index];
        }

        return $random;
    }
}
