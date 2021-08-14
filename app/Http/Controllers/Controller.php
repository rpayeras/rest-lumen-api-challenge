<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function __construct()
    {
        $this->customErrorFormat();
    }

    /**
     * Custom error response format
     *
     * @return Illuminate\Http\Response
     */
    private function customErrorFormat()
    {
        static::$errorFormatter = function ($validator) {
            $arr = [];
            foreach ($validator->errors()->all() as $value) {
                $arr[] = $value;
            }

            return [
                'errors' => $arr,
            ];
        };
    }
}
