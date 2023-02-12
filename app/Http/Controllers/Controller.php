<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseApi(bool $statusTransaction, array $message =[], array $data =[] ): array
    {

        switch ((strtolower($message['type']))) {

            case 'success'  :  $message['code'] = 200;  break;
            case 'error'    :  $message['code'] = 500;  break;
            case 'warning'  :  $message['code'] = 300;  break;
            default:   return abort(500);          break;

        }

        return [
            'transaction' => [
                'status'  => $statusTransaction
            ],
            'data'        => $data,
            'message'     => $message
        ];
    }

}
