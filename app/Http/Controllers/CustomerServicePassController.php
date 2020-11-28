<?php

namespace App\Http\Controllers;

use App\Models\CustomerServicePass;
use App\Models\Customer;
use App\Models\ServicePass;
use Illuminate\Http\Request;

class CustomerServicePassController extends Controller
{
    public function assign(Request $request) {
        $customer = Customer::find($request['customer']);
        if (!is_object($customer)) {
            return $this->responseError('error_customer_not_found');
        }
        $pass = ServicePass::find($request['service_pass']);
        if (!is_object($pass)) {
            return $this->responseError('error_service_pass_not_found');
        }
        if (!$customer->assignPass($pass)) {
            return $this->responseError('error_assigning_service_pass_to_user_failed');
        }
        return $this->response('success_pass_assigned_to_customer');
    }
}
