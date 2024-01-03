<?php

namespace Modules\LirCrud\app\Traits;

use Illuminate\Support\Str;

trait LoadMethodBySetupPatternTrait
{
    /**
     * @var string must be a namespace
     */
    protected $loadMethodBySetupPatternClass;

    public function loadMethodBySetupPattern(string $startWord, string $endWord, callable $callback)
    {
        if (! $class = $this->loadMethodBySetupPatternClass) {
            $class = self::class;
        }
        
        collect(
            (new \ReflectionClass($class))->getMethods()
        )->filter(function ($v) use ($startWord, $endWord) {
            return $v->getName() != ($startWord.$endWord)
                && Str::startsWith($v->getName(), $startWord)
                && Str::endsWith($v->getName(), $endWord);
        })->pluck('name')
        ->unique()
        ->map(function ($v) use ($callback) {
            if (method_exists($this, $v)) {
                $callback($v);
            }
        });
    }
}
