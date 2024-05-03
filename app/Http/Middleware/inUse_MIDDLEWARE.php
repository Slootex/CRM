<?php

namespace App\Http\Middleware;

use App\Models\intern;
use App\Models\warenausgang;
use App\Models\wareneingang;
use Closure;
use Illuminate\Http\Request;

class inUse_MIDDLEWARE
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $req, Closure $next, $id)
    {
        $id = $req->route('id');

        $eingang = wareneingang::where('component_number', $id)->first();
        $intern = intern::where('component_number', $id)->first();
        $ausgang = warenausgang::where('component_number', $id)->first();

        if ($eingang == null && $intern == null && $ausgang == null) {
            return $next($req);
        } else {
            return redirect()->back();
        }
    }
}
