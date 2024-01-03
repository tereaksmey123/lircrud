<?php

namespace Modules\LirCrud\app\Supports\CrudPanel\Traits;

trait QueryTrait
{
    public $query;

    // ----------------
    // ADVANCED QUERIES
    // ----------------

    /**
     * Add another clause to the query (for ex, a WHERE clause).
     *
     * Examples:
     * $this->crud->addClause('active');
     * $this->crud->addClause('type', 'car');
     * $this->crud->addClause('where', 'name', '==', 'car');
     * $this->crud->addClause('whereName', 'car');
     * $this->crud->addClause('whereHas', 'posts', function($query) {
     *     $query->activePosts();
     * });
     *
     * @param  callable  $function
     * @return mixed
     */
    public function addClause($function)
    {
        return call_user_func_array([$this->query, $function], array_slice(func_get_args(), 1));
    }

    /**
     * Use eager loading to reduce the number of queries on the table view.
     *
     * @param  array|string  $entities
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function with($entities)
    {
        return $this->query->with($entities);
    }

    /**
     * Order the results of the query in a certain way.
     *
     * @param  string  $field
     * @param  string  $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function orderBy($field, $order = 'asc')
    {
        if (request()->has('order')) {
            return $this->query;
        }

        return $this->query->orderBy($field, $order);
    }

    /**
     * Group the results of the query in a certain way.
     *
     * @param  string  $field
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function groupBy($field)
    {
        return $this->query->groupBy($field);
    }

    /**
     * Limit the number of results in the query.
     *
     * @param  int  $number
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function limit($number)
    {
        return $this->query->limit($number);
    }

    /**
     * Take a certain number of results from the query.
     *
     * @param  int  $number
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function take($number)
    {
        return $this->query->take($number);
    }

    /**
     * Start the result set from a certain number.
     *
     * @param  int  $number
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function skip($number)
    {
        return $this->query->skip($number);
    }

    /**
     * Count the number of results.
     *
     * @return int
     */
    public function count()
    {
        return $this->query->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Add Over Package Code
    |--------------------------------------------------------------------------
    */

    /**
     * Set Min & Max per page
     *
     * @param bool|integer $perPage
     * @param bool|integer $maxPerPage
     */
    public function paginate($perPage = false, $maxPerPage = false)
    {
        $request = request();

        $setPerPage = $request->per_page ?: 100;
        $maxPerPage = $maxPerPage ?: 200;

        if (! $perPage) {
            $perPage = $setPerPage;
        } else {
            if (! is_numeric($perPage)) {
                $perPage = $setPerPage;
            }
        }

        if ($perPage > $maxPerPage) {
            $perPage = $maxPerPage;
        } 

        return $this->query->paginate($perPage);
    }

    public function skipTakeGet($offset, $limit)
    {
        $defaultLimit =  $limit ?: 200;
        $defaultOffset =  $offset ?: 0;

        $limit = is_numeric($limit = request()->limit) ? $limit : $defaultLimit;
        $offset = is_numeric($offset = request()->offset) ? $offset : $defaultOffset;

        if ($limit > $defaultLimit) {
            $limit = $defaultLimit;
        }

        return $this->query->skip($offset)->take($limit)->get();
    }
}
