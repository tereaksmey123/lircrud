<?php

namespace Modules\LirCrud\app\Macro;

class RouteMacro
{
    public static function crud()
    {
        return function ($segment, $controller, array $extraData = []) {
            return resolve($controller)->setupRoutes($segment, $controller, $extraData);
        };
    }
}