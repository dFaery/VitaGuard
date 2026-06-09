<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpecialty extends Model
{
    use HasFactory;
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'username', 'username');
    }

    public function specialty()
    {        
        return $this->belongsTo(Specialty::class, 'specialty_id', 'id');
    }
}
