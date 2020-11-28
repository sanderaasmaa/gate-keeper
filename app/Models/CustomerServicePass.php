<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CustomerServicePass extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

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
        if ($this->save()) {
            return $this->logUsage();
        }
        return false;
    }

    private function logUsage() {
        $log = [
            'date' => Carbon::now()->format('d.m.Y H:i:s'),
            'name' => $this->customer->name,
            'description' => $this->service->name . ' visit',
        ];
        return Storage::append('visit_log.txt', implode(' ', $log));
    }
}
