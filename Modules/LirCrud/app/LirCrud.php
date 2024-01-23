<?php

namespace Modules\LirCrud\app;

use Illuminate\Support\Facades\Route;
use Modules\LirCrud\Macro\RouteMacro;

class LirCrud
{
    /**
     * @var string module name
     */
    const MNAME = 'lircrud';

    /**
     * @var string module name with prefix ::
     */
    const MNAME_SYMBOL = self::MNAME.'::';

    /**
     * @var string Operation setting name
     */
    const FORM_REQUEST = 'FORM_REQUEST';
}
