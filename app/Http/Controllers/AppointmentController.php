<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use Illuminate\Http\Request;

/**
 * @group Appointment management
 *
 * This endpoint allows you to register pets appointments
 */
class AppointmentController extends Controller
{
    /**
     * Register appointment
     *
     * This route can be used to register a new pet appointment
     *
     * @urlParam id integer required The pet id.
     * @bodyParam date string required Date of the appointment on the format yyyy-mm-dd
     * @bodyParam description string The pet specie. It must have value 'C' (Cachorro) or 'G' (Gato).
     *
     */
    public function store(Request $request, int $petId)
    {
        $validation = IlluminateValidator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'description' => 'string',
        ]);

        if ($validation->fails()) {
            return $this->badRequest($validation->messages());
        }

        return Appointment::create([
            'petId' => $petId,
            'date' => $request->input('date'),
            'description' => $request->input('description'),
        ]);
    }
}
