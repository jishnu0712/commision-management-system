<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Doctor;

class Percentage extends Model
{
    use HasFactory;
    protected $fillable = ['doctor_id', 'dept_id', 'percentage'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
