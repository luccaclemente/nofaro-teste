<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use App\Models\Pet;
use App\Models\Specie;
use \DB;
class PetController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('name')) {
            return Pet::where('name', 'like', '%'.$request->input('name').'%')->paginate();
        }

        return Pet::paginate();
    }

    public function show($id)
    {
        return Pet::with('appointments')
            ->find($id);
    }

    public function store(Request $request)
    {
        $validation = IlluminateValidator::make($request->all(), $this->getValidationRules());

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
        $validation = IlluminateValidator::make($request->all(), $this->getValidationRules());

        if ($validation->fails()) {
            return $this->badRequest($validation->messages());
        }

        $pet = Pet::findOrFail($id);
        $pet->update([
            'name' => $request->input('name'),
            'specieId' => Specie::where('shortDescription', $request->input('specie'))->first()->specieId,
        ]);

        return $pet;
    }

    public function delete(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $pet->delete();

        return $this->success();
    }

    private function getValidationRules() {
        return [
            'name' => 'required|min:2',
            'specie' => 'required|exists:species,shortDescription',
        ];
    }
}
