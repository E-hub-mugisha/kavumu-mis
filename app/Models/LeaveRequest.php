<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $fillable = [
        'staff_id','reason','start_date','end_date','status','leave_type'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
