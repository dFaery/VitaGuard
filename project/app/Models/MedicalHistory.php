<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;
    
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_username', 'username');
    }

    public function inputtedBy()
    {
        return $this->belongsTo(User::class, 'inputted_by', 'username');
    }    
}
