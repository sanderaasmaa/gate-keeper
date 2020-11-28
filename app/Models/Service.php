<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function passes() {
        return $this->hasMany(ServicePass::class);
    }

    public function grantAccess(Customer $customer, $checkOnly = true) {
        $customerPasses = CustomerServicePass::where('customer_id', $customer->id)->where('service_id', $this->id)->get();
        foreach ($customerPasses as $customerPass) {
            if (!$customerPass->isValid()) {
                continue;
            }
            if ($checkOnly) {
                return true;
            }
            return $customerPass->useService();
        }
        return false;
    }
}
