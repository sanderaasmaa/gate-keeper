<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServicePass extends Model
{
    public function getExpiryDate() {
        return Carbon::now()->addDays($this->expiry_days);
    }
}
