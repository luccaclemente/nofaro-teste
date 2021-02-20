<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

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
        return Pet::create($request->all());
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
