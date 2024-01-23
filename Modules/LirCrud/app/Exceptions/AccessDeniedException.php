<?php

namespace Modules\LirCrud\app\Exceptions;

use Exception;

class AccessDeniedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // if (! $request->expectsJson()) {
        //     return parent::__construct();
        // }

        return inertia('LirCrud::ErrorPage', [
            'status' => 403
        ]);

        // dd(request()->inertia());
        
        return response()->json(['message' => $this->message], 403);
    }
}
