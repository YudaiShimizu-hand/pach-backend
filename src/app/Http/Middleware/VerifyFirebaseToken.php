<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\InvalidToken;


class VerifyFirebaseToken
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
        $serviceAccountPath = base_path(env('FIREBASE_SERVICE_ACCOUNT'));
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $auth = $factory->createAuth();

        $token = $request->bearerToken();  // リクエストからトークンを取得

        try {
            $verifiedIdToken = $auth->verifyIdToken($token);
        } catch (InvalidToken $e) {
            // トークンが無効な場合はエラーレスポンスを返す
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $uid = $verifiedIdToken->claims()->get('sub');
        // ここで$uidを使ってユーザーを識別します

        $request->attributes->add(['firebase_user_id' => $uid]);

        return $next($request);
    }
}
