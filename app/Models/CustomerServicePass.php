<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServicePass extends Model
{
    use HasFactory;

    public function isValid() {
        if ($this->repetitions <= 0) {
            return false;
        }
        if ($this->expiry_date < Carbon::now()) {
            return false;
        }
        return true;
    }

    public function useService() {
        $this->repetitions--;
        return $this->save();
    }
}
