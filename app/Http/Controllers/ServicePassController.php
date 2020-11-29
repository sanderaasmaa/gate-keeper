<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePass;
use Illuminate\Http\Request;

class ServicePassController extends Controller
{
    public function create(Request $request, $serviceId) {
        $service = Service::find($serviceId)->first();
        if (!is_object($service)) {
            return $this->responseError('error_service_not_found');
        }
        $existing = ServicePass::where('name', $request['name'])->first();
        if (is_object($existing)) {
            return $this->responseError('error_pass_already_exists');
        }
        $pass = new ServicePass();
        $pass->name = $request['name'];
        $pass->service_id = $serviceId;
        if (!$pass->set('repetitions', $request['repetitions'])) {
            return $this->responseError('error_unable_to_set_repetitions');
        }
        if (!$pass->set('expiry_days',$request['expiry_days'])) {
            return $this->responseError('error_unable_to_set_expiry_days');
        }
        if (!$pass->save()) {
            return $this->responseError('error_unable_to_save_service_pass');
        }
        return $this->response($pass, 'new_service_pass_added');
    }
}
