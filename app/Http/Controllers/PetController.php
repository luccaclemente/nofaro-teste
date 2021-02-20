<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as IlluminateValidator;
use App\Models\Pet;
use App\Models\Specie;
use \DB;

/**
 * @group Pet management
 *
 * This endpoint allows you to manage pet registrations
 */
class PetController extends Controller
{
    /**
     * List pets
     *
     * This function returns a paginated list of pets without its appointments.
     * The standard amount per page is two pets
     *
     * @urlParam name When filled filters the results by the pets name
     * @urlParam page integer Page to be displayed. Defaults to 1
     *
     */
    public function index(Request $request)
    {
        if($request->has('name')) {
            return Pet::where('name', 'like', '%'.$request->input('name').'%')->simplePaginate();
        }

        return Pet::simplePaginate();
    }

    /**
     * Show pet
     *
     * This route returns a full detailed list of informations of the given pet
     *
     * @urlParam id integer required The pet id that are requested
     *
     */
    public function show($id)
    {
        return Pet::findOrFail($id)
            ->with('appointments');
    }


    /**
     * Register pet
     *
     * This route can be used to register new pets on the database
     *
     * @bodyParam name string required The pet name. It must have at leats 2 characters.
     * @bodyParam specie string required The pet specie. It must have value 'C' (Cachorro) or 'G' (Gato).
     *
     */
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

    /**
     * Update pet information
     *
     * This route can be used to update an existent pet information
     *
     * @bodyParam name string required The pet name. It must have at leats 2 characters.
     * @bodyParam specie string required The pet specie. It must have value 'C' (Cachorro) or 'G' (Gato).
     *
     */
    public function update(Request $request, int $id)
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

    /**
     * Remove pet
     *
     * This route can be used to delete all pet and its appointments information
     *
     * @urlParam id integer required The pet id that must have all its information deleted
     *
     */
    public function delete(Request $request, int $id)
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
