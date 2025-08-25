<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PassportClientController extends Controller
{
    // Step 1: Redirect to Passport Authorization
    public function redirectToPassport()
    {
        $query = http_build_query([
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'redirect_uri' => url('/auth/callback'),
            'response_type' => 'code',
            'scope' => '', // add scopes if needed
        ]);

        return redirect(url('/oauth/authorize?') . $query);
    }

    // Step 2: Handle Callback and Exchange Code for Token
    public function handlePassportCallback(Request $request)
    {
        $http = new Client;

        $response = $http->post(url('/oauth/token'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                'redirect_uri' => url('/auth/callback'),
                'code' => $request->code,
            ],
        ]);

        $tokens = json_decode((string) $response->getBody(), true);

        // You can store tokens in session or database as needed
        return response()->json($tokens);
    }
}
