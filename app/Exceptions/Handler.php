<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{

    public static $DEFAULT_MESSAGE = 'Algo que não esta certo deu errado! Por favor, entre em contato conosco.';

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if (config('app.env')=='production' && app()->bound('sentry') && $this->shouldReport($exception)) {
            // Slack Report
            Log::channel('slack')->error('[PaymentService Fatal Error] Fatal erro: '.$exception->getMessage());

            // Sentry Report
            // \Sentry\configureScope(function (Scope $scope): void {
            //     if ($user = auth()->user()) {
            //         $scope->setUser([
            //             'id' => $user->id,
            //             'email' => $user->email,
            //             'cpf' => $user->cpf
            //         ]);
            //     }
            // });
            app('sentry')->captureException($exception);
        }
    
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            return response()->redirect('login')->with('status', 'Token expired, please try again.');
        }

        if ($exception instanceof ModelNotFoundException/* && $request->wantsJson()*/) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
            
            // Não usado nesse Projeto pois não é em Api. Usar wantsJson
            // return response()->json(
            //     [
            //         'success' => false,
            //         'message' => 'Registro não encontrado'
            //     ],
            //     406
            // );
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException/* && $request->wantsJson()*/) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $exception->getMessage()
                ],
                406
            );
        }

        if ($request->ajax() || $request->wantsJson())
        {
            $json = [
                'success' => false,
                'message' => $exception->getMessage(),
                'obs'     => 'handlerByAjaxWantsJson',
                'error' => [
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ],
            ];
            return response()->json($json, 400);
        }
        
        // Convert all non-http exceptions to a proper 500 http exception
        // if we don't do this exceptions are shown as a default template
        // instead of our own view in resources/views/errors/500.blade.php
        if (config('app.env')=='production' && $this->shouldReport($exception) && !$this->isHttpException($exception) && !config('app.debug')) {
            $exception = new HttpException(500, 'Whoops!');
        }

        return parent::render($request, $exception);
    }
}
