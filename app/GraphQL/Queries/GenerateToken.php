<?php

namespace App\GraphQL\Queries;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

final class GenerateToken
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $auth = app('firebase.auth');
        try {
            $verifiedIdToken = $auth->verifyIdToken($args['token']);
            return 'valido';
        } catch (FailedToVerifyToken $e) {
            return 'invalido';
            echo 'The token is invalid: '.$e->getMessage();
        }
    }
}
