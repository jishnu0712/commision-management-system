<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Percentage;
use App\Models\Transaction;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['dept_name', 'description', 'percentage'];


    public function percentage()
    {
        return $this->hasMany(Percentage::class, 'dept_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'dept_id');
    }
}
