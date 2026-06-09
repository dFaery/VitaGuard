<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function patient(){
        return $this->belongsTo(Member::class, 'patient', 'username');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }

    public function doctor(){
        return $this->schedule()->doctor();
    }
}
