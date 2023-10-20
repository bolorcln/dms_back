<?php

namespace App\Http\Controllers;

use App\Models\TableauServerConfig;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;
use Symfony\Component\Uid\UuidV4;
use Webpatser\Uuid\Uuid;

class TableauServerController extends Controller
{
    public function getJwtToken()
    {
        $serverConfig = TableauServerConfig::first();
        if ($serverConfig == null) {
            return response()->json(['error' => 'There is no server config'], Response::HTTP_NOT_FOUND);
        }

        $key = $serverConfig->client_secret;
        $payload = [
            'iss' => $serverConfig->client_id,
            'exp' => Carbon::now()->addMinutes(5)->getTimestamp(),
            'jti' => Uuid::generate(4)->string,
            'aud' => 'tableau',
            'sub' => $serverConfig->access_name,
            'scp' => [
                'tableau:views:embed',
                'tableau:metrics:embed'
            ],
            'https://tableau.com/oda' => true,
            'https://tableau.com/groups'=> ['Contractors', 'Team C'],
            'Region' => 'East'
        ];
        $headers = [
            'kid' => $serverConfig->secret_id,
            'iss' => $serverConfig->client_id
        ];

        $jwt = JWT::encode($payload, $key, 'HS256', null, $headers);

        return response()->json([
            'token' => $jwt
        ]);
    }
}