<?php

namespace App\Units\Auth\Http\Controllers;

use App\Support\Http\Response;
use App\Support\Http\ApiController;
use App\Units\Auth\Http\Requests\SendResetLinkRequest;
use App\Units\Auth\Http\Requests\ResetPasswordRequest;
use App\Domains\Account\PasswordRecovery as PasswordRecoveryService;

class ResetPasswordController extends ApiController
{
    /**
     * The PasswordRecoveryService instance.
     *
     * @var PasswordRecoveryService
     */
    protected $service;

    /**
     * Create a ResetPasswordController instance.
     *
     * @param  Response                 $response
     * @param  PasswordRecoveryService  $service
     */
    public function __construct(Response $response, PasswordRecoveryService $service)
    {
        $this->response = $response;
        $this->service = $service;
    }

    /**
     * Handle a request to send a reset password link to an user.
     *
     * @param  SendResetLinkRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(SendResetLinkRequest $request)
    {
        $sended = $this->service->sendResetLinkEmail($request);

        if ($sended) {
            return $this->response->withAccepted('O link para redefinição de senha foi enviado para o seu e-mail');
        }

        return $this->response->withInternalServerError('Houve um erro ao tentar enviar o e-mail para redefinição de senha');
    }

    /**
     * Handle a request to reset the password for an user.
     *
     * @param  ResetPasswordRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        $reseted = $this->service->reset($request);

        if ($reseted) {
            return $this->response->withAccepted('Sua senha foi alterada com sucesso');
        }

        return $this->response->withInvalid('O token informado é inválido');
    }
}
