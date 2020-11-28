<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller {
    //
    public function list() {
        $response = ['success' => true];
        return response()->json($response);
    }
}
