<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RedirectIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $installFile = File::exists(base_path('install'));
        $updateFile = File::exists(base_path('update'));
        if ($installFile) {
            return redirect()->route('install');
        }
        elseif($updateFile)
        {
            return redirect()->route('update');
        }
        return $next($request);
    }
}