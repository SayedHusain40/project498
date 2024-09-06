<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
    
        if (Auth::check()) {
            DB::table('user_sessions')->updateOrInsert(
                ['user_id' => Auth::id(), 'created_at' => now()], // Unique user and session time
                [
                    'login_time' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'updated_at' => now(),
                ]
            );
        }
    
        return $response;
    }
    
}
