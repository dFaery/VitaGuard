<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $table = 'facilities';
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function schedules()
    {
        return $this->hasMany(FacilitySchedule::class,'facility_id','id');
    }

    public function dispensededPrescription()
    {
        return $this->hasMany(PrescriptionDetail::class,'facility_id','id');
    }

    public function facilityAdmins()
    {
        return $this->hasMany(FacilityAdmin::class,'facility_id','id');
    }
}
