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
        if (! $request->inertia() && $request->expectsJson()) {
            return response()->json(['message' => $this->message], 403);
        }

        return inertia('LirCrud::ErrorPage', [
            'status' => 403
        ]);
    }
}
