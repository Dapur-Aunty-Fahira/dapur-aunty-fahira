<?php
namespace App\Traits;

trait ApiResponse
{
    protected function success($data = null, $message = 'Berhasil', $statusCode = 200)
    {
        return response()->json([
            'status' => 'sukses',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function error($message = 'Terjadi kesalahan', $statusCode = 500, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    protected function validationError($errors)
    {
        return response()->json([
            'status' => 'error_validation',
            'message' => 'Data tidak valid',
            'errors' => $errors,
        ], 422);
    }
}
