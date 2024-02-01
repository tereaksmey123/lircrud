<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Crud;

use Modules\LirCrud\app\LirCrud;
use Modules\LirCrud\app\Exceptions\AccessDeniedException;

trait ResponseTrait
{
    protected function getResponseSetting(): array
    {
        return $this->get('setResponseProps') ?? [];
    }

    /**
     * Set Response Props class
     * * By default: it will be push value into setting
     * * Unless set $reset to true
     * * CATUIONS: $classname::responseProps() must wrap by a key else it possible to override other props
     */
    public function setResponseSetting(string $classname, bool $reset = false): void
    {
        if (! class_exists($classname)) {
            throw new \InvalidArgumentException('Class not exitst: '.$classname);
        }

        $this->set('setResponseProps', $reset
            ? $classname
            : collect([...$this->getResponseSetting(), ...[$classname]])->unique()->toArray()
        );
    }

    /**
     * Response Content base on given arguments
     *
     * @return inertia|response helper
     */
    protected function response(array $data = [], string|bool $page = false, int $status = 200)
    {
        if (request()->inertia() && is_string($page) || $page) {
            return inertia($page, $data);
        }

        return response()->json($data, $status);
    }

    public function responseAction()
    {
        // TO DO
        return $this->response();
    }

    /**
     * Response Page Content with additional props from Crud setting
     *
     * @return inertia|response helper
     */
    public function responsePage(string $page)
    {
        return $this->response(
            page: $page,
            data: [
                ...collect($this->getResponseSetting())->mapWithKeys(
                    fn ($v) => $v::responseProps()
                )->merge($this->get('setResponseCustomProps') ?? [])
                ->toArray(),
            ]
        );
    }

    public function responseProps(): array
    {
        return [
            ...collect([
                'pageTitle',
                'pageTitles'
            ])->mapWithKeys(fn ($v) => [$v => $this->get($v)])->toArray(),
        ];
    }
}
