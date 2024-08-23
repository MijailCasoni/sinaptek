<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
          return $next($request);
        }

        $user = Auth::guard()->user();

        $now = Carbon::now();

        $updated_at = Carbon::parse($user->updated_at);

        $absence = $now->diffInMinutes($updated_at);

        // If user has been inactivity longer than the allowed inactivity period
        if ($absence > config('session.lifetime')) {
          Auth::guard()->logout();

          $request->session()->invalidate();

          return $next($request);
        }

        $user->updated_at = $now->format('Y-m-d H:i:s');
        $user->save();

        return $next($request);
    }
}
