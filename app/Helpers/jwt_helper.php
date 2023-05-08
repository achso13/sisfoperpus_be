<?php

use Firebase\JWT\JWT;

function generateToken($user) {
    $key = getenv('JWT_SECRET_KEY');
    $payload = [
        "iat" => time(),
        "exp" => time() + 3600,
        "userId" => $user['id'],
        "role" => $user['role']
    ];

    $token = JWT::encode($payload, $key,'HS256');
    return $token;
}