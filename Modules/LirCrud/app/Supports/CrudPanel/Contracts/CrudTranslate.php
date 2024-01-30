<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Contracts;

interface CrudTranslate
{
    /**
     * Translate without prefix
     */
    public static function trans(string $key, array $replace = [], ?string $local = null): string;

    /**
     * Translate with lircrud:: prefix
     */
    public static function lirTrans(string $key, array $replace = [], ?string $local = null): string;
}
