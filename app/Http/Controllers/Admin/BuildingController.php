<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Building;
use App\Room;
use Auth;

class BuildingController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$buildings = Building::orderBy('created_at', 'desc')->get();
        $rooms = Room::all();
        $buildingsCantBeDelete = array();

        foreach ($rooms as $row) {
            if (!in_array($row->building_id, $buildingsCantBeDelete)) {
                array_push($buildingsCantBeDelete, $row->building_id);
            }
        }

        // print_r($buildingsCantBeDelete);

    	return view('admin.building.index')
    		->with('buildings', $buildings)
            ->with('buildingsCantBeDelete', $buildingsCantBeDelete);
    }

    public function create() {
        abort_if(Auth::user()->user_type == 2, 404);

    	return view('admin.building.create');
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'short_name' => 'required|max:191'
    	]);

    	$building = New Building;
    	$building->name = $request->name;
    	$building->short_name = $request->short_name;
    	$building->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('building.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$building = Building::find($id);

    	return view('admin.building.edit')
    		->with('building', $building);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'short_name' => 'required|max:191'
    	]);

    	$building = Building::find($id);
    	$building->name = $request->name;
    	$building->short_name = $request->short_name;
    	$building->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('building.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$building = Building::find($id);
    	$building->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('building.index');
    }

    public function show($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
        $building = Building::find($id);
        $rooms = Room::where('building_id', $building->id)->get();

        return view('admin.building.show')
            ->with('building', $building)
            ->with('rooms', $rooms);
    }
}
