<?php
/**
 * Created by PhpStorm.
 * User: suporte
 * Date: 16/01/2018
 * Time: 12:44
 */

namespace App\Exceptions;


class Error
{
    /**
     * Padrão de retorno dos erros do servidor
     *
     * @param string $error
     * @param string $description
     * @param int $tipo
     * @return \Illuminate\Http\JsonResponse
     */
    static function getError($error,$message,$tipo)
    {
        return response()->json([
            'error'     => $error,
            'message'     => $message,
            ],
            (int) $tipo
        );
    }
}