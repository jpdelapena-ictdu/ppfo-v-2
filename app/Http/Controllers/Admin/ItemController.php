<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\Item;
use App\Building;
use App\Computer;
use Auth;

class ItemController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$items = Item::orderBy('updated_at', 'desc')->get();
    	$itemArr = [];
    	$x = 0;

    	foreach ($items as $row) {
    		$room = Room::find($row->room_id);
            $building = Building::find($room->building_id);
    		$itemArr[$x++] = [
    			'id' => $row->id,
                'building_id' => $building->id,
                'building' => $building->name,
    			'room_id' => $row->room_id,
    			'room' => $room->name,
    			'description' => $row->description,
    			'type' => $row->type,
    			'category' => $row->category,
    			'quantity' => $row->quantity,
    			'working' => $row->working,
    			'not_working' => $row->not_working,
    			'for_repair' => $row->for_repair
    		];
    	}

    	$itemArr = json_decode(json_encode($itemArr));

    	return view('admin.item.index')
    		->with('items', $itemArr);

    }

    public function create() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$rooms = Room::orderBy('updated_at', 'desc')->get();

    	return view('admin.item.create')
    		->with('rooms', $rooms);
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);
        if($request->category != 'none'){
            if($request->category == '0'){
                $this->validate($request, [
                    'quantity' => 'required|numeric',
                    'room' => 'required'
                    ]);
                for($i = 1; $i <= $request->quantity; $i++){
                    $computer = New Computer;
                    $computer->pc_number = 'PC' . $i;
                    $computer->room_id = $request->room;
                    $computer->status = 0;
                    $computer->save();                    
                }

                \Alert::success('Computer has been successfully added.')->flash();

                return redirect()->route('item.index');
            }
        }
    	$this->validate($request, [
    		'room_id' => 'required',
    		'description' => 'required',
    		'type' => 'required|max:191',
    		'category' => 'required|max:191|not_in:none',
    		'quantity' => 'required|numeric',
            'date_purchased' => 'required',
            'serial' => 'required',
            'date_issued' => 'required',
            'amount' => 'required',
    		'working' => 'required_without_all:not_working,for_repair,for_calibrate',
    		'not_working' => 'required_without_all:working,for_repair,for_calibrate',
    		'for_repair' => 'required_without_all:working,not_working,for_calibrate',
            'for_calibrate' => 'required_without_all:working,not_working,for_repair'
    	]);

    	$item = New Item;
    	$item->room_id = $request->room_id;
    	$item->description = $request->description;
    	$item->type = $request->type;
    	$item->category = $request->category;
    	$item->quantity = $request->quantity;
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

    	return redirect()->route('item.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$item = Item::find($id);
    	$rooms = Room::orderBy('updated_at', 'desc')->get();

    	return view('admin.item.edit')
    		->with('item', $item)
    		->with('rooms', $rooms);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'room_id' => 'required',
    		'description' => 'required',
    		'type' => 'required|max:191',
    		'category' => 'required|max:191',
    		'quantity' => 'required|numeric',
    		'working' => 'required_without_all:not_working,for_repair',
    		'not_working' => 'required_without_all:working,for_repair',
    		'for_repair' => 'required_without_all:working,not_working'

    	]);

    	$item = Item::find($id);
    	$item->room_id = $request->room_id;
    	$item->description = $request->description;
    	$item->type = $request->type;
    	$item->category = $request->category;
    	$item->quantity = $request->quantity;
    		$item->working = $request->working;
    		$item->not_working = $request->not_working;
    		$item->for_repair = $request->for_repair;
    	$item->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('item.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
    	$item = Item::find($id);
    	$item->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('item.index');
    }

    public function downloadItem() {
        $items = Item::all();
        $dataToDownload = [];
        $csvName = 'Items.'.date("m.d.y.g:i");
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

    /*public function show(Request $request) {
        if($request->ajax()) {
            $item = Item::find($request->id);
            // $room = Room::find($item->room_id);
            $itemArr = [];
            $itemArr[0] = [
            	'id' => $item->id,
            	'room_id' => $item->room_id,
            	'room' => $room->name,
            	'description' => $item->description,
            	'type' => $item->type,
            	'category' => $item->category,
            	'quantity' => $item->quantity,
            	'working' => $item->working,
            	'not_working' => $item->not_working,
            	'for_repair' => $item->for_repair
            ];

            $itemArr = json_decode(json_encode($itemArr));
            
            return response()->json($item);
            // echo $messageArr;
        }
    }*/
}
