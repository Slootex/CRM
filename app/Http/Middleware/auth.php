<?php

namespace App\Http\Middleware;

use App\Models\activity;
use App\Models\permission;
use App\Models\role;
use Closure;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $req, Closure $next)
    {


        if (\Illuminate\Support\Facades\Auth::user() != null) {
            
            $loc = Location::get($req->ip());
            
            if($loc != false) {
                $ac = new activity();
                $ac->user = auth()->user()->id;
                $ac->url = url()->current();
                $ac->ip  = $req->ip();
                $ac->region = $loc->regionName . ", " . $loc->cityName . " " . $loc->zipCode ;
                $ac->save();
            }


            if(auth()->user()->getPermissionsViaRoles()->where("url", url()->current())->isEmpty() == true) {

                return $next($req);

            } else {
                return redirect('kein-zugang');
            }
            
        } else {

            $loc = Location::get($req->ip());

            if($loc != false) {
                $ac = new activity();
                $ac->user = "Unbekannt";
                $ac->url = url()->current();
                $ac->ip  = $req->ip();
                $ac->region = $loc->regionName . ", " . $loc->cityName . " " . $loc->zipCode ;
                $ac->save();
            }

            return redirect('employee/login');
        }
    }
}
