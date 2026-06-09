<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDetail extends Model
{
    use HasFactory;
    
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class,'medicine_id','id');
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'dispensed_at','id');
    }

}
