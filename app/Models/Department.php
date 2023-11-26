<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Percentage;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['dept_name', 'description'];


    public function percentage()
    {
        return $this->hasMany(Percentage::class, 'dept_id');
    }
}
