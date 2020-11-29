<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function list() {
        $response = Customer::select(['id', 'email', 'name'])->get();
        return $this->response($response);
    }
}
