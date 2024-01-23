<?php

namespace Modules\LirCrud\app\Traits;

use Illuminate\Support\Str;

trait LoadMethodBySetupPatternTrait
{
    public function loadMethodBySetupPattern(
        string $startWord,
        string $endWord,
        callable $callback,
        false|string $namespace = false
    ) {
        if (! $namespace) {
            $namespace = self::class;
        }
        
        collect(
            (new \ReflectionClass($namespace))->getMethods()
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
