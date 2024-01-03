<?php

namespace  Modules\LirCrud\app\Traits\Controllers;

trait ResponseTrait
{
    /**
     * @param mixed $message
     * @param mixed $data
     *
     * @return json
     */
    public function responseOk($message, $data = null)
    {
        return response()->json([
            'data'    => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param mixed $message
     * @param integer $status
     *
     * @return json
     */
    public function responseFail($message, $status = 404)
    {
        return response()->json([
            'message' => $message,
        ], $status);
    }

    /**
     * @param mixed $validate
     * @param integer $status
     *
     * @return json
     */
    public function responseValidateError($validate, $status = 422)
    {
        try {
            $error = $validate->errors();
        } catch (\Throwable $th) {
            $error = $validate;
        }

        return response()->json([
            "message" => "The given data was invalid.",
            "errors" => $error
        ], $status);
    }
}
