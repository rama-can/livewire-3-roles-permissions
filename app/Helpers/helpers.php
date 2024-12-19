<?php

use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

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

// markdown to html
if (!function_exists('markdownToHtml')) {
    function markdownToHtml($content)
    {
        return app(\App\Services\Markdown\MarkdownService::class)->convertToHtml($content);
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
