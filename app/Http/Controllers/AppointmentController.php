<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validation = IlluminateValidator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d',
            'description' => 'string',
        ]);

        if ($validation->fails()) {
            return $this->badRequest($validation->messages());
        }

        return Appointment::create($request->all());
    }
}
