<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Middleware running. Session data: ', Session::all());
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            Log::info('SUCCESS: Locale "' . $locale . '" has been set.');
        } else {
            Log::warning('FAILURE: No "locale" key in session.');
        }
        return $next($request);
    }
}
