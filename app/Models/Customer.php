<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function passes() {
        return $this->hasMany(CustomerServicePass::class);
    }

    public function assignPass(ServicePass $pass) {
        $customerPass = new CustomerServicePass();
        $customerPass->customer_id = $this->id;
        $customerPass->service_pass_id = $pass->id;
        $customerPass->service_id = $pass->service_id;
        $customerPass->repetitions = $pass->repetitions;
        $customerPass->repetitions = $pass->repetitions;
        $customerPass->expiry_date = $pass->getExpiryDate();
        return $customerPass->save();
    }
}
