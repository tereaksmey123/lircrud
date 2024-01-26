<?php

namespace Modules\LirCrud\app\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class LocaleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locale = request()->getPreferredLanguage();

        if (! $locale) {
            return response()->json([
                'message' => 'Invalid/Missing Accept-Language Headers'
            ], 400);
        }

        $cacheLang = Cache::remember('lircrud_translateion_'.$locale, now()->addMonth(), function () use ($locale) {
            $allTranslations = collect($this->rootLang($locale))
                ->flatMap(function ($file) use ($locale) {
                    return [
                        ($translation = $file->getBasename('.php')) => trans(
                            $translation,
                            [],
                            $locale
                        ),
                    ];
                })->toArray();

            return [
                ...$allTranslations,
                'modules' => [
                    ...$this->loadLocale('lircrud::default', $locale),
                    ...$this->loadLocale('lirsetting::default', $locale)
                ]
            ];
        });

        return response()->json([
            'data' => $cacheLang,
            'locale' => $locale,
            'driver' => 'file'
        ]);
    }

    protected function rootLang(string $locale)
    {
        $path = resource_path('lang/' .$locale);

        if (! is_dir($path)) {
            $path = resource_path('lang/' . app()->getFallbackLocale());
        }

        return is_dir($path) ? File::allFiles($path) : [];
    }

    protected function loadLocale(string $fileName, $locale = false)
    {
        [$path, $module] = explode('::', $fileName);

        // check if module is present
        if ($path && $module) {
            return [
                $path => [
                    $module =>trans($fileName, [], $locale ?: app()->getFallbackLocale())
                ]
            ];
        }

        return [
            $fileName => trans($fileName, [], $locale ?: app()->getFallbackLocale())
        ];
    }
}
