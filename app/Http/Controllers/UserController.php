<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class UserController extends Controller
{
    public function getUsertoken(Request $request)
    {
        $auth = app('firebase.auth');

        $firebaseToken = $request->input('firebase_token');

        try {
            $verifiedIdToken = $auth->verifyIdToken($firebaseToken);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
            ], 401);
        } catch (FailedToVerifyToken  $e) {
            return response()->json([
                'message' => 'Unauthorized - Token is invalide: ' . $e->getMessage()
            ], 401);
        }

        $uid = $verifiedIdToken->claims()->get('sub');

        // Retrieve the user model linked with the Firebase UID
        $user = User::firstOrCreate(['firebaseUID' => "$uid"]);

        // Generate user token
        $token = $user->createToken('User login token');

        return ['token' => $token->plainTextToken];
    }
}
