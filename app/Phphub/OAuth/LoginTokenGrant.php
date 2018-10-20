<?php

namespace Phphub\OAuth;

use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Server\Exception\InvalidRequestException;

class LoginTokenGrant extends BaseGrant
{

    protected $identifier = 'login_token';

    public function getUserId(Request $request, $verifier)
    {
        // Get ('username') é uma maneira compatível de escrever para o cliente
        // Modificado para o ID do usuário será mais estável
        $user_id = $this->server->getRequest()->request->get('username', null);
        if (is_null($user_id)) {
            throw new InvalidRequestException('user_id');
        }

        $login_token = $this->server->getRequest()->request->get('login_token', null);
        if (is_null($login_token)) {
            throw new InvalidRequestException('login_token');
        }

        return call_user_func($verifier, $user_id, $login_token);
    }
}
