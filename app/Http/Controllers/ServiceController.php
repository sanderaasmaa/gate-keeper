<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller {
    //
    public function list() {
        $response = Service::with('passes')->get();
        return $this->response($response);
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
            return $this->response(null, $options['access_msg']);
        }
        return $this->response(null, 'access_denied', false);
    }

    public function create(Request $request) {
        $existing = Service::where('name', $request['name'])->first();
        if (is_object($existing)) {
            return $this->responseError('error_service_already_exists');
        }
        $service = new Service();
        $service->name = $request['name'];
        if (!$service->save()) {
            return $this->responseError('error_unable_to_save_service');
        }
        return $this->response($service, 'new_service_added');
    }
}
