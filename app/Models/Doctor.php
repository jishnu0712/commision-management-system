<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'mobile', 'email', 'address', 'gender', 'specialization', 'profile_pic', 'hospital_name',
    ];
}
