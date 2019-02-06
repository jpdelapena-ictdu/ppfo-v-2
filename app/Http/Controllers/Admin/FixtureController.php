<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fixture;
use App\Room;
use Auth;

class FixtureController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$fixtures = Fixture::orderBy('updated_at', 'desc')->get();

    	return view('admin.items.fixture.index')
    		->with('fixtures', $fixtures);
    }

    public function create() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$rooms = Room::orderBy('updated_at', 'desc')->get();

    	return view('admin.items.fixture.create')
    		->with('rooms', $rooms);
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'room_id' => 'not_in:none',
    		'type' => 'required' 
    	]);

    	/*$fixture = New Fixture;
    	$fixture->room_id = $request->room_id;
    	$fixture->description = $request->description;
    	$fixture->type = $request->type;
    	$fixture->quantity = $request->quantity;
    	if (!$request->working == '') {
    		$fixture->working = $request->working;
    	}
    	if (!$request->not_working == '') {
    		$fixture->not_working = $request->not_working;
    	}
    	if (!$request->for_repair == '') {
    		$fixture->for_repair = $request->for_repair;
    	}
    	$fixture->date_purchased = $request->date_purchased;
    	$fixture->price = $request->price;
    	$fixture->date_installed = $request->date_installed;
    	$fixture->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('fixture.index');*/
    }
}
