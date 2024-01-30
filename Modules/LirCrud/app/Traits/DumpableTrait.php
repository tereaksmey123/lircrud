<?php

namespace Modules\LirCrud\app\Traits;

trait DumpableTrait
{
    public function dd()
    {
        dd($this);

        return $this;
    }

    public function dump()
    {
        dump($this);
        
        return $this;
    }
}