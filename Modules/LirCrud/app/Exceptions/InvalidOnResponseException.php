<?php

namespace Modules\LirCrud\app\Exceptions;

use Exception;

class InvalidOnResponseException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if (! $request->expectsJson()) {
            return parent::__construct();
        }
        
        return response()->json(['message' => $this->message], 422);
    }
}
