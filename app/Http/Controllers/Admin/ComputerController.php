<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Computer;
use App\Room;
use Auth;

class ComputerController extends Controller
{

    public function create() {
	abort_if(Auth::user()->user_type == 2, 404);

    	$rooms = Room::orderBy('updated_at', 'desc')->get();

    	return view('admin.computers.create')
    		->with('rooms', $rooms);
    }

    public function index() {
    	abort_if(Auth::user()->user_type == 2, 404);

    	$computers = Computer::orderBy('updated_at', 'desc')->get();

    	$pcArr = [];
    	$x = 0;

    	foreach ($computers as $row) {
    		$room = Room::find($row->room_id);
    		$pcArr[$x++] = [
    			'id' => $row->id,
    			'pc_number' => $row->pc_number,
                'room' => $room->name,
                'status' => $row->status
    		];
    	}

    	$pcArr = json_decode(json_encode($pcArr));

    	return view('admin.computers.index')
    		->with('computers', $pcArr);

    }

    public function store(Request $request) {

    	abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'pc_number' => 'required',
    		'room' => 'required',
    		'status' => 'required'
    	]);

    	$computer = New Computer;
    	$computer->pc_number = $request->pc_number;
    	$computer->room_id = $request->room;
    	$computer->status = $request->status;
    	$computer->save();

    	// show a success message
        Alert::success('The Computer has been added successfully.')->flash();

    	return redirect()->route('computer.index');

    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$computer = Computer::find($id);
    	$rooms = Room::orderBy('updated_at', 'desc')->get();
    	$status = $computer->status;
    	if($status == 0){
    		$status = "Working";
    	}elseif($status == 1){
    		$status = "Not Working";
    	}elseif($status == 2){
    		$status = "For Repair";
    	}elseif($status == 3){
    		$status = "For Calibrate";
    	}

    	return view('admin.computers.edit')
    		->with('computer', $computer)
    		->with('rooms', $rooms)
    		->with('status', $status);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'room' => 'required',
    		'pc_number' => 'required',
    		'status' => 'required|max:191'

    	]);

    	$computer = Computer::find($id);
    	$computer->room_id = $request->room;
    	$computer->pc_number = $request->pc_number;
    	$computer->status = $request->status;
    	$computer->save();

    	// show a success message
        \Alert::success('The computer has been modified successfully.!')->flash();

    	return redirect()->route('computer.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$computer = Computer::find($id);
    	$computer->delete();

    	// show a success message
        \Alert::success('Computer has been deleted.')->flash();

        return redirect()->route('computer.index');
    }
 
}
