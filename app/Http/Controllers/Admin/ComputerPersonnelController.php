<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Computer;
use App\Room;
use App\Component;
use App\Building;
use Auth;
use Alert;

class ComputerPersonnelController extends Controller
{
    public function index() {

        $buildings = Building::find(Auth::user()->building_id)->get();
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::orderBy('updated_at', 'desc')->get();
        $components = Component::orderBy('updated_at', 'desc')->get();
        $pcArr = [];
        $x = 0;
        foreach($rooms as $room){
                foreach ($computers as $row) {
                    if($row->room_id == $room->id){
                        $pcArr[$x++] = [
                            'id' => $row->id,
                            'pc_number' => $row->pc_number,
                            'room' => $room->name,
                            'status' => $row->status
                        ];
                    }
                }
            
        }
        $pcArr = json_decode(json_encode($pcArr));

        return view('personnel.computers.index')
        ->with('computers', $pcArr)
        ->with('parts', $components);

    }

    public function create() {
        $buildings = Building::find(Auth::user()->building_id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();

        return view('personnel.computers.create')
            ->with('rooms', $rooms);
    }

    public function store(Request $request) {
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

        return redirect()->route('personnel.computer.index');
    }

    public function edit($id) {

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

    	return view('personnel.computers.edit')
    		->with('computer', $computer)
    		->with('rooms', $rooms)
    		->with('status', $status);
    }

    public function update(Request $request, $id) {

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

    	return redirect()->route('personnel.computer.index');
    }

    public function destroy($id) {
    	$computer = Computer::find($id);
    	$computer->delete();

    	// show a success message
        \Alert::success('Computer has been deleted.')->flash();

        return redirect()->route('personnel.computer.index');
    }
}
