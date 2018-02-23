<?php

namespace App\Http\Controllers\Api;

use App\Services\RsaService;
use App\Http\Controllers\Controller;
use Exception;

class RsaController extends Controller
{
    /**
     * 获取公钥
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKeys()
    {
        try
        {
            $crypt = new RsaService();
            $crypt->select('rsa_api');
            return response()->json([
                'status' => 200,
                'data' => [
                    'rsa_public_key'=>$crypt->pubkey
                ]
            ]);
        }
        catch (Exception $exception)
        {
            return response()->json([
                'status' => 404,
                'message' => '读取公匙失败'
            ]);
        }

    }
}
