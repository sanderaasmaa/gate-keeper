<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServicePass extends Model
{
    public function getExpiryDate() {
        return Carbon::now()->addDays($this->expiry_days);
    }

    public function set($attribute, $input) {
        if (!is_numeric($input)) {
            return false;
        }
        if ($input < 0) {
            $this->$attribute = 0;
        } elseif ($input == 0) {
            $this->$attribute = 99999;
        } else {
            $this->$attribute = round($input, 0);
        }
        return true;
    }
}
