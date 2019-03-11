<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Building;
use App\Room;
use App\User;
use App\Item;
use App\Computer;
use App\Component;
use Auth;

class RoomPersonnelController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	abort_if(Auth::user()->user_type == 1, 404);

    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $building = Building::find(Auth::user()->building_id);
        $items = Item::all();
        $computers = Computer::all();
        $roomsCantBeDelete = array();

        // get rooms that cant be delete
        foreach ($items as $row) {
            foreach($computers as $row1){
            if (!in_array($row->room_id, $roomsCantBeDelete) || !in_array($row1->room_id, $roomsCantBeDelete)  ) {
                array_push($roomsCantBeDelete, $row->room_id);
                array_push($roomsCantBeDelete, $row1->room_id);
            }
            }
        }
    	
    	return view('personnel.room.index')
    		->with('rooms', $rooms)
            ->with('building', $building)
            ->with('roomsCantBeDelete', $roomsCantBeDelete);
    }

    public function create() {
        abort_if(Auth::user()->user_type == 1, 404);

        $building = Building::find(Auth::user()->building_id);

        return view('personnel.room.create')
            ->with('building', $building);
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 1, 404);

        $this->validate($request, [
            'name' => 'required|max:191',
            'short_name' => 'required|max:191',
            'in_charge' => 'required|max:191'
        ]);

        $room = New Room;
        $room->building_id = Auth::user()->building_id;
        $room->name = $request->name;
        $room->short_name = $request->short_name;
        $room->in_charge = $request->in_charge;
        $room->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('room.personnel.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $room = Room::find($id);
        $building = Building::find(Auth::user()->building_id);

        return view('personnel.room.edit')
            ->with('room', $room)
            ->with('building', $building);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $this->validate($request, [
            'name' => 'required|max:191',
            'short_name' => 'required|max:191',
            'in_charge' => 'required|max:191'
        ]);

        $room = Room::find($id);
        $room->building_id = Auth::user()->building_id;
        $room->name = $request->name;
        $room->short_name = $request->short_name;
        $room->in_charge = $request->in_charge;
        $room->save();

        // show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

        return redirect()->route('room.personnel.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $room = Room::find($id);
        $room->delete();

        // show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('room.personnel.index');
    }

    public function show($id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $room = Room::find($id);
        $items = Item::where('room_id', $room->id)->get();

        return view('personnel.room.show')
            ->with('room', $room)
            ->with('items', $items);
    }

        public function computershow($id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $room = Room::find($id);
        $computers = Computer::where('room_id', $room->id)->get();
        $components = Component::where('room_id', $room->id)->get();

        return view('personnel.room.showpc')
            ->with('room', $room)
            ->with('computers', $computers)
            ->with('parts', $components);
    }

    public function createItemInRoom($id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $room = Room::find($id);

        return view('personnel.room.create-item')
            ->with('room', $room);
    }

    public function storeItemInRoom(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);

        if($request->category != 'none'){
            if($request->category == '0'){
                $this->validate($request, [
                    'quantity' => 'required|numeric'
                    ]);
                for($i = 1; $i <= $request->quantity; $i++){
                    $computer = New Computer;
                    if($i < 10){
                    $computer->pc_number = 'PC0' . $i;
                    }else{
                    $computer->pc_number = 'PC' . $i;   
                    }   
                    $computer->room_id = $id;
                    $computer->status = 0;
                    $computer->save();                    
                }

                \Alert::success('Computer has been successfully added.')->flash();

                return redirect()->route('room.personnel.computer', $id);
            }
        }
        
        $this->validate($request, [
            'description' => 'required',
            'category' => 'required|not_in:none',
            'quantity' => 'required|numeric',
            'working' => 'required_without_all:not_working,for_repair,for_calibrate',
            'not_working' => 'required_without_all:working,for_repair,for_calibrate',
            'for_repair' => 'required_without_all:working,not_working,for_calibrate',
            'for_calibrate' => 'required_without_all:working,not_working,for_repair'
        ]);

        $item = New Item;
        $item->room_id = $id;
        $item->description = $request->description;
        $item->brand = $request->brand;
        $item->category = $request->category;
        $item->quantity = $request->quantity;
        $item->serial = $request->serial;
        $item->date_purchased = $request->date_purchased;
        $item->amount = $request->amount;
        $item->date_issued = $request->date_issued;
        $item->remarks = $request->remarks;

        if (!$request->working == '') {
            $item->working = $request->working;
        }
        if (!$request->not_working == '') {
            $item->not_working = $request->not_working;
        }
        if (!$request->for_repair == '') {
            $item->for_repair = $request->for_repair;
        }
        if (!$request->for_calibrate == '') {
            $item->for_calibrate = $request->for_calibrate;
        }
        $item->save();

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        return redirect()->route('room.personnel.show', $id);
    }

    public function createComputerInRoom($id){
        abort_if(Auth::user()->user_type == 1, 404);


        $room = Room::find($id);

        return view('personnel.room.create-computer')
            ->with('room', $room);
    }

    public function storeComputerInRoom(Request $request, $id){
        $this->validate($request, [
            'pc_number' => 'required',
            'status' => 'required'
        ]);

        $computer = New Computer;
        $computer->room_id = $id;
        $computer->pc_number = $request->pc_number;
        $computer->status = $request->status;
        $computer->save();

        \Alert::success('Computer has been successfully added.')->flash();
        return redirect()->route('room.personnel.computer', $id);
    }

    public function downloadItem($id) {
        $rObj = Room::find($id);
        $items = Item::where('room_id', $id)->get();
        $dataToDownload = [];
        $csvName = $rObj->name.'.'.date("m.d.y.g:i");
        $x = 0;

        // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename='.$csvName.'.csv');
         
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
         
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        // send the column headers
        fputcsv($file, array('ID', 'Building', 'Room', 'Item', 'Quantity', 'Working', 'Not Working', 'For Repair'));

        foreach($items as $row) {
            $room = Room::find($row->room_id);
            $building = Building::find($room->building_id);

            $dataToDownload[$x++] = [
                'id' => $row->id,
                'building' => $building->name,
                'room' => $room->name,
                'item' => $row->description,
                'quantity' => $row->quantity,
                'working' => $row->working == ''? '0':$row->working,
                'not_working' => $row->not_working == ''? '0':$row->not_working,
                'for_repair' => $row->for_repair == ''? '0':$row->for_repair
            ];
        }

        // print_r($dataToDownload);
        // output each row of the data

        foreach ($dataToDownload as $row)
        {
        fputcsv($file, $row);
        }
         
        exit();

        return redirect()->back();
    }
}
