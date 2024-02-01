<?php

namespace Modules\LirCrud\app\Supports\CrudPanel;

use Modules\LirCrud\app\Traits\DumpableTrait;
use Modules\LirCrud\app\Supports\Facades\Crud;
use Modules\LirCrud\app\Supports\CrudPanel\Contracts\CrudFieldApi;
use Modules\LirCrud\app\Supports\CrudPanel\Contracts\CrudTranslate;

class Translate implements CrudTranslate
{
    const LIR_TRANS = 'lircrud::';

    public static function trans(string $key, array $replace = [], ?string $local = null): string
    {
        return __($key, $replace, $local);
    }

    public static function lirTrans(string $key, array $replace = [], ?string $local = null): string
    {
        return static::trans(static::LIR_TRANS.$key, $replace, $local);
    }
}
