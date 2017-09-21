<?php

namespace App\Http\Controllers\Email;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $user = User::whereConfirmationToken($request->token)->firstOrFail();

        $user->confirmation_token = null;
        $user->confirmed = true;
        $user->save();

        return response()->json(['data' => 'Your email was verified'], 201);
    }
}
