<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'specieId'];

    protected $primaryKey = 'petId';

    protected $perPage = 2;

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
