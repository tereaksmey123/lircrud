<?php

namespace Modules\LirCrud\app\Macro;

class RouteMacro
{
    public static function lircrud()
    {
        return function (string $segment, string $controller, array $extraData = []) {
            return resolve($controller)->setupRoutes($segment, $controller, $extraData);
        };
    }
}