<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\Building;
use App\Item;
use Auth;

class RoomController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$rooms = Room::orderBy('updated_at', 'desc')->get();
    	$roomArr = [];
    	$x = 0;
        $items = Item::all();
        $roomsCantBeDelete = array();

        // get rooms that cant be delete
        foreach ($items as $row) {
            if (!in_array($row->room_id, $roomsCantBeDelete)) {
                array_push($roomsCantBeDelete, $row->room_id);
            }
        }
    	
    	foreach ($rooms as $row) {
            abort_if(Auth::user()->user_type == 2, 404);

    		$building = Building::find($row->building_id);
    		$roomArr[$x++] = [
    			'id' => $row->id,
    			'building_id' => $row->building_id,
    			'building' => '(' .$building->short_name. ') ' .$building->name,
    			'name' => $row->name,
    			'short_name' => $row->short_name,
    			'in_charge' => $row->in_charge,
    			'created_at' => $row->created_at,
    			'updated_at' => $row->updated_at
    		];
    	}

    	$roomArr = json_decode(json_encode($roomArr));

    	return view('admin.room.index')
    		->with('rooms',  $roomArr)
            ->with('roomsCantBeDelete', $roomsCantBeDelete);
    }

    public function create() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$buildings = Building::orderBy('updated_at', 'desc')->get();

    	return view('admin.room.create')
    		->with('buildings', $buildings);
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'building_id' => 'required',
    		'name' => 'required|max:191',
    		'short_name' => 'required|max:191',
    		'in_charge' => 'required|max:191'
    	]);

    	$room = New Room;
    	$room->building_id = $request->building_id;
    	$room->name = $request->name;
    	$room->short_name = $request->short_name;
    	$room->in_charge = $request->in_charge;
    	$room->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('room.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$room = Room::find($id);
    	$buildings = Building::orderBy('updated_at', 'desc')->get();

    	return view('admin.room.edit')
    		->with('room', $room)
    		->with('buildings', $buildings);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'building_id' => 'required',
    		'name' => 'required|max:191',
    		'short_name' => 'required|max:191',
    		'in_charge' => 'required|max:191'
    	]);

    	$room = Room::find($id);
    	$room->building_id = $request->building_id;
    	$room->name = $request->name;
    	$room->short_name = $request->short_name;
    	$room->in_charge = $request->in_charge;
    	$room->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('room.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$room = Room::find($id);
    	$room->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('room.index');
    }

    public function show($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
        $room = Room::find($id);
        $items = Item::where('room_id', $room->id)->get();

        return view('admin.room.show')
            ->with('room', $room)
            ->with('items', $items);
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
