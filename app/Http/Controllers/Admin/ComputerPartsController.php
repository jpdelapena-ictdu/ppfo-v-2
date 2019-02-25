<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComputerParts;
use App\Computer;
use Auth;
use Alert;

class ComputerPartsController extends Controller
{
    public function create($id) {
	abort_if(Auth::user()->user_type == 2, 404);

		$computer = Computer::find($id);

    	return view('admin.computers.parts.create')
    		->with('computer', $computer);
    }

    public function store(Request $request, $id) {
    	abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'type' => 'required',
    		'brand' => 'required',
    		'description' => 'required',
    		'date_purchased' => 'required'
    	]);
    	$computer = Computer::find($id);
    	$parts = New ComputerParts;
    	$parts->pc_id = $computer->id;
    	$parts->type = $request->type;
    	$parts->brand = $request->brand;
    	$parts->description = $request->description;
    	$parts->date_purchased = $request->date_purchased;
    	$parts->save();

    	// show a success message
        Alert::success('The Component has been added successfully.')->flash();

    	return redirect()->route('computer.index');

    }
}
