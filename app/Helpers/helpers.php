<?php

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

/**
 * Formats a given date to Indonesian locale.
 *
 * @param string $date The date string to be formatted.
 * @return string The formatted date string in Indonesian locale.
 */
if (! function_exists('dateFormatID')) {
    function dateFormatID($date)
    {
        // Carbon::setLocale('id');
        return Carbon::parse($date)->translatedFormat('j F Y');
    }
}

/**
 * Formats a given amount into Indonesian Rupiah currency format.
 *
 * @param float|int $amount The amount to be formatted.
 * @return string The formatted amount as a string in Indonesian Rupiah currency format.
 */
if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        // Rp 268.000
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

/**
 * Get the value of a theme setting by its key.
 *
 * @param string $key The key of the theme setting.
 * @return string The value of the theme setting.
 */
if (!function_exists('themes')) {
    function themes($group, $key)
    {
        return Setting::where('group', $group)
            ->where('key', $key)
            ->pluck('value')
            ->first();
    }
}

// get current locale
if (!function_exists('currentLocale')) {
    function currentLocale()
    {
        return app()->getLocale();
    }
}

// get all locale
if (!function_exists('supportedLocales')) {
    function supportedLocales()
    {
        // return implode(',', array_keys(Config::get('laravellocalization.supportedLocales')));
        return array_keys(Config::get('laravellocalization.supportedLocales'));
    }
}

// get all language
if (!function_exists('supportedLanguages')) {
    function supportedLanguages()
    {
        return Config::get('laravellocalization.supportedLocales');
    }
}

// language switcher
if (!function_exists('languageSwitcher')) {
    function languageSwitcher()
    {
        $locales = Config::get('laravellocalization.supportedLocales');
        $currentLocale = app()->getLocale();
        $output = '';
        foreach ($locales as $key => $value) {
            $output .= '<a href="' . route('set-locale', $key) . '" class="dropdown-item ' . ($currentLocale == $key ? 'active' : '') . '">' . $value['native'] . '</a>';
        }
        return $output;
    }
}

if (!function_exists('getCurrentPost')) {
    /**
     * Get the current post based on the route and locale.
     *
     * @return Post|null
     */
    function getCurrentPost()
    {
        $routeName = Request::route()?->getName();

        if ($routeName === 'blogs.detail') {
            $slug = Request::route('slug');
            return Post::whereTranslation('slug', $slug, app()->getLocale())
                ->with(['user', 'category'])
                ->first();
        }

        return null;
    }
}

if (!function_exists('generateUniqueCode')) {
    /**
     * Generate a unique code.
     *
     * @param int $length The length of the code.
     * @return string The generated unique code.
     */
    function generateUniqueCode($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $code;
    }
}

// get all language except current language
// if (!function_exists('getOtherLanguage')) {
//     function getOtherLanguage()
//     {
//         $locales = Config::get('laravellocalization.supportedLocales');
//         $currentLocale = app()->getLocale();
//         $output = '';
//         foreach ($locales as $key => $value) {
//             if ($currentLocale != $key) {
//                 $output .= '<a href="' . route('set-locale', $key) . '" class="dropdown-item">' . $value['native'] . '</a>';
//             }
//         }
//         return $output;
//     }
// }
