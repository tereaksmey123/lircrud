<?php

namespace Modules\LirCrud\app\Supports\CrudPanel;

use Modules\LirCrud\app\Supports\Enum\CrudEnum;
use Modules\LirCrud\app\Supports\Enum\PropertyEnum;
use Modules\LirCrud\app\Supports\CrudPanel\Abstracts\CrudProperty;

class Column extends CrudProperty
{
    use \Modules\LirCrud\app\Traits\MacroableTrait;
    use \Modules\LirCrud\app\Traits\DumpableTrait;

    protected string $key = 'columns';

    public function __construct(protected ?string $name = null, protected bool $init = true)
    {
        if (! $init) {
            return;
        }
        
        if (! $this->property()) {
            $this->addProperty([PropertyEnum::KEY->value => $name])
            ->label($name)
            ->type('Columns.Text');
        }

        if (method_exists($this, $setup = 'setup')) {
            $this->$setup();
        }
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    /**
     * trigger when method not exists, we will it into key: options
     */
    public function __call($name, $arguments): static
    {
        if (static::hasMacro($name)) {
            return $this->macroCall($name, $arguments);
        }

        return $this;
    }

    public static function responseProps(): array
    {
        $static = new static(init: false);
        
        return [
            $static->key => $static->properties()
        ];
    }
}
