<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller {
    //
    public function list() {
        $response = [
            'services' => Service::with('passes')->get()
        ];
        return response()->json($response);
    }
}
