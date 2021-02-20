<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use App\Models\Pet;
use App\Models\Specie;

class PetController extends Controller
{
    public function index()
    {
        return Pet::all();
    }

    public function show($id)
    {
        return Pet::find($id);
    }

    public function store(Request $request)
    {
        $validation = IlluminateValidator::make($request->all(), [
            'name' => 'required|min:2',
            'specie' => 'required|exists:species,shortDescription',
        ]);

        if ($validation->fails()) {
            return $this->badRequest($validation->messages());
        }

        return Pet::create([
            'name' => $request->input('name'),
            'specieId' => Specie::where('shortDescription', $request->input('specie'))->first()->specieId,
        ]);
    }

    public function update(Request $request, $id)
    {
        $Pet = Pet::findOrFail($id);
        $Pet->update($request->all());

        return $Pet;
    }

    public function delete(Request $request, $id)
    {
        $Pet = Pet::findOrFail($id);
        $Pet->delete();

        return 204;
    }
}
