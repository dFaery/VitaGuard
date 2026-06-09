<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor', 'username');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member', 'username');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class,'appointment_id','id');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class,'consultation_id','id');
    }

    public function prescriptionDetails()
    {
        return $this->hasMany(PrescriptionDetail::class);
    }

}
