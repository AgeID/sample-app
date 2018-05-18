<?php namespace App\Http\Middleware;

use Closure;

class AgeId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        $ageIdData = session()->get('ageId', null);
        if (is_null($ageIdData) || (isset($ageIdData['status']) && $ageIdData['status'] !== 'verified')) {
            return redirect('sfw');
        }

        return $next($request);
    }
}
