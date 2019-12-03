<?php

namespace App\Http\Middleware;

use Closure;

class ClassTeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user() && $request->user()->teacher_role !='class_teacher'){
            return new Response(view('unauthorized')->with('role', 'Class Teacher'));
        }
        return $next($request);
    }
}
