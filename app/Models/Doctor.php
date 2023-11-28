<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Percentage;
use App\Models\Bill;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'mobile', 'email', 'address', 'gender', 'specialization', 'profile_pic', 'hospital_name',
    ];

    public function percentage()
    {
        return $this->hasMany(Percentage::class);
    }

    public function bill()
    {
        return $this->hasMany(Bill::class);
    }

    public function payment()
    {
        return $this->hasMany(DoctorPayment::class);
    }
}
