<?php

namespace App\Http\ApiControllers;

use Auth;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Gate;
use Illuminate\Http\Request;
use App\Transformers\UserTransformer;
use App\Models\User;
use App\Models\Reply;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    public function me()
    {
        return $this->show(Auth::id());
    }

    public function show($id)
    {
        $user = User::find($id);
        $user->links = true; // Retornar links no Transformer, minha opinião na web
        return $this->response()->item($user, new UserTransformer());
    }

    public function update($id, UpdateUserRequest $request)
    {
        $user = User::findOrFail($id);

        if (Gate::denies('update', $user)) {
            throw new AccessDeniedHttpException();
        }

        try {
            $user = $request->performUpdate($user);
            return $this->response()->item($user, new UserTransformer());
        } catch (ValidatorException $e) {
            throw new UpdateResourceFailedException('Não é possível atualizar as informações do usuário:'. output_msb($e->getMessageBag()));
        }
    }
}
