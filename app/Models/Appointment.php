<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends BaseModel
{
    use HasFactory;

    protected $fillable = ['petId', 'description', 'created_at'];
    protected $primaryKey = 'appointmentId';
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
