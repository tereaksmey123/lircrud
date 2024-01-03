<?php

namespace Modules\LirCrud\app\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // \Auth::logout();
 
        // $request->session()->invalidate();
     
        // $request->session()->regenerateToken();

        return Inertia::render('LirCrud::Dashboard', [
            'event' => [],
        ]);
    }
}
