<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class EnsureInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $installPath = 'install';
        $isInstallRoute = $request->is($installPath) || $request->is($installPath . '/*');
        $isInstalled = File::exists(storage_path('installed.lock'));

        if (!$isInstalled && !$isInstallRoute) {
            return redirect()->route('install.welcome');
        }

        if ($isInstalled && $isInstallRoute) {
            return redirect('/');
        }

        return $next($request);
    }
}
