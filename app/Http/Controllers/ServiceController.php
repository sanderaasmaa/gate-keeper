<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

    public function canAccess(Request $request, $customerId, $serviceId) {
        $options = [
            'check_only' => true,
            'access_msg' => 'can_access',
        ];
        return $this->access($request, $customerId, $serviceId, $options);
    }

    public function access(Request $request, $customerId, $serviceId,
                           $options = ['check_only' => false, 'access_msg' => 'access_granted_wish_customer_a_nice_visit']) {
        $customer = Customer::find($customerId);
        if (!is_object($customer)) {
            return $this->responseError('error_customer_not_found');
        }
        $service = Service::find($serviceId);
        if (!is_object($service)) {
            return $this->responseError('error_service_not_found');
        }
        if ($service->grantAccess($customer, $options['check_only'])) {
            return $this->response($options['access_msg']);
        }
        return $this->response('access_denied', false);
    }
}
