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
        $factory = (new Factory)->withServiceAccount('../../../pach-app-credential.json');
        $auth = $factory->createAuth();

        $token = $request->bearerToken();  // リクエストからトークンを取得

        try {
            $verifiedIdToken = $auth->verifyIdToken($token);
        } catch (InvalidToken $e) {
            // トークンが無効な場合はエラーレスポンスを返す
            return response()->json(['error' => $e->getMessage()], 401);
        }

        $uid = $verifiedIdToken->getClaim('sub');
        // ここで$uidを使ってユーザーを識別します
        return $next($request);
    }
}
