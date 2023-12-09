<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bill;
use App\Models\Department;

class Transaction extends Model
{
    use HasFactory;

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
