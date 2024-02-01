<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Modules\LirCrud\app\Supports\Enum\CrudEnum;
use Modules\LirCrud\app\Supports\CrudPanel\Translate;

trait TranslateTrait
{
    private function setDefaultTranslate()
    {
        $this->setTranslate(Translate::class);
    }

    public function setTranslate(string $classNamespace)
    {
        if (! class_exists($classNamespace)) {
            throw new \InvalidArgumentException('Invalid Translate class: '.$classNamespace);
        }

        $this->set(CrudEnum::SET_TRANSLATE->value, $classNamespace);
    }

    /**
     * Translate without prefix
     */
    public function trans(string $key, array $replace = [], ?string $local = null): string
    {
        return $this->get(CrudEnum::SET_TRANSLATE->value)::trans($key, $replace, $local);
    }

    /**
     * Internal LirCrud Module translate with name prefix
     */
    public function lirTrans(string $key, array $replace = [], ?string $local1 = null): string
    {
        return $this->get(CrudEnum::SET_TRANSLATE->value)::lirTrans($key, $replace, $local1);
    }
}
