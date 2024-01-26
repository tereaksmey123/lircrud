<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

use Modules\LirCrud\app\LirCrud;
use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait InertiaTrait
{
    public function inertiaShare()
    {
        return [
            ...collect([
                'pageTitle',
                'pageTitles'
            ])->mapWithKeys(fn ($v) => [$v => $this->get($v)])->toArray(),
            ...collect($this->get('inertiaShare'))->mapWithKeys(
                fn ($v, $k)  => [$k => $this->get($v)]
            )->toArray()
        ];
    }
}
