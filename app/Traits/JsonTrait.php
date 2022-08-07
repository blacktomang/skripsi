<?php

namespace App\Traits;

trait JsonTrait
{

  public function successResponse($data = null, $message = "Sukses", $status = 200)
  {
    return response()->json([
      'status' => false,
      'message' => [
        'head' => 'Berhasil',
        'body' => $data? $data:$message
      ]
    ], $status);
  }
  public function errorResponse($message = "Gagal", $status = 500)
  {
    return response()->json([
      'status' => true,
      'message' => [
        'head' => 'Gagal',
        'body' => $message
      ]
    ], $status);
  }
}
