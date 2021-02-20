<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * Describe this table's relation with Pet.
     *
     * @return \App\Models\Pet
     */
    public function pet()
    {
        return $this->belongsToOne(
            'App\Models\Pet',
            'petId',
            'petId'
        );
    }
}
