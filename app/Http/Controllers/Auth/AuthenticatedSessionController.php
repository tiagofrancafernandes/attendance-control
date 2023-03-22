<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @return Response|JsonResponse
     */
    public function store(LoginRequest $request): Response|JsonResponse
    {
        $request->authenticate();

        return response()->json([
            'user' => $request->user()->returnOnly($request->input('select', [])),
            'token' => $request->user()->plainTextToken(
                tokenName: Str::slug("login {$request->email}"),
                expiresAt: \null, //TODO
                abilities: ['*'] //TODO
            ),
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response|JsonResponse
    {
        $loggedOut = (bool) $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => $loggedOut,
        ], $loggedOut ? 200 : 422);
    }
}
