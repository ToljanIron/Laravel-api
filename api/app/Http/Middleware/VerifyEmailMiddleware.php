<?php

namespace App\Http\Middleware;

use App\Events\UserRegistered;
use App\Models\User;
use Closure;

class VerifyEmailMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (!$user->hasVerifiedEmail()){
                $url = config('app.frontend_url') . '/verify-email/' . $user->id . '/' . sha1($user->getEmailForVerification());
                event(new UserRegistered($user, $url));

                return response()->json(['message' => 'Your email address is not verified.'], 403);
            }

            return $next($request);
        }

        return response()->json(['message' => 'Invalid Credentials'], 401);
    }
}
