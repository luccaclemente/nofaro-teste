<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    /**
     * Describe this table's relation with Appointment.
     *
     * @return \App\Models\Appointment
     */
    public function appointments()
    {
        return $this->hasMany(
            'App\Models\Appointment',
            'petId',
            'petId'
        );
    }
}
