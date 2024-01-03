<?php

namespace Modules\LirCrud\app\Supports\Validate;

class ValidateTransform
{
    use \Modules\LirCrud\app\Traits\LoadMethodBySetupPatternTrait;

    public function transformed(string|array $requestClass, $replaceValues = [])
    {
        $replaceValues = ['password' => 'password::min:8,letter'];
        if (is_array($requestClass)) {
            $rules = $this->processing($requestClass, $replaceValues);
        } else {
            // when $requestClass is not array, we expect <String Class Name>
            $formRequest = new $requestClass;

            // dd($formRequest->messages());

            $rules = method_exists($formRequest, $ruleName = 'jsRules')
                    ? $formRequest->{$ruleName}()
                    : $this->processing($formRequest->rules(), $replaceValues)
                ;
        }

        return $rules;
    }

    protected function processing($rules, $replaceValues)
    {
        $rules = collect($rules)->map(
            fn ($v) => collect($v)->map(function ($vv, $kk) {
                $value = $vv;

                $this->loadMethodBySetupPattern('fn', 'Rule', function ($methodName) use (&$value, $vv){
                    $value = $this->{$methodName}($vv) ?: $value;
                });
                // // intention to transform registered of class object here
                

                return $value;
            })->filter()->toArray()
        )->filter();

        // replace rule name to other rule by $replaceValues
        if (is_array($replaceValues) && $replaceValues) {
            $rules = $rules->mapWithKeys(function ($v, $k) use ($replaceValues) {
                return [$k => collect($v)->map(fn ($vv) => ($replaceValues[$vv] ?? $vv))];
            });
        }

        return $rules->toArray();
    }

    protected function fnPasswordRule($value): string|false
    {
        if ($value instanceof \Illuminate\Validation\Rules\Password) {
            return 'password';
        }

        return false;
    }
}