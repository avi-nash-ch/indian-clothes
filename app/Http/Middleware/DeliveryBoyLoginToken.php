<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DeliveryBoy;

class DeliveryBoyLoginToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = DeliveryBoy::where('token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       //  $request->user = $user;

        return $next($request);
    }
}
