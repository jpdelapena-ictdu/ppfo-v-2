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

        return view('admin.computers.create')
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

        return redirect()->route('computer.personnel.index');

    }
}
