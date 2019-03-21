<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use App\Order;
use App\Room;
use App\Building;

class OrderController extends Controller
{
     public function index() {
    	abort_if(Auth::user()->user_type == 1, 404);

    	$orders = Order::where('building_id', Auth::user()->building_id)->get();
    	$reqArr = [];
    	$x = 0;

    	foreach ($orders as $row) {
    		$room = Room::find($row->room_id);

    		$reqArr[$x++] = [
    			'id' => $row->id,
    			'room' => $room->name,
                'nature' => $row->nature,
                'request' => $row->request,
                'action_taken' => $row->action_taken,
                'prepared_by' => $row->prepared_by,
                'status' => $row->status,
                'worked_by' => $row->worked_by
    		];
    	}

    	$reqArr = json_decode(json_encode($reqArr));

    	return view('personnel.request.index')
    		->with('orders', $reqArr);

    }

    public function create(){
    	abort_if(Auth::user()->user_type == 1, 404);
    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();

    	return view('personnel.request.create')
    		->with('rooms', $rooms);
    }

    public function store(Request $request) {
    	abort_if(Auth::user()->user_type == 1, 404);
    	if($request->nature == "0"){
    	$this->validate($request, [
    		'room' => 'required',
    		'nature' => 'required|not_in:none',
    		'others' => 'required',
    		'order' => 'required'
    	]);
    	}else{
    		$this->validate($request, [
    		'room' => 'required',
    		'nature' => 'required|not_in:none',
    		'order' => 'required'
    	]);
    	}


    	$order = New Order;
    	$order->building_id = Auth::user()->building_id;
    	$order->room_id = $request->room;
    	if($request->nature != "0"){
    	$order->nature = $request->nature;
    	}else{
    	$order->nature = $request->others;		
    	}
    	$order->request = $request->order;
    	$order->action_taken = $request->action;
    	$order->prepared_by = Auth::user()->name;
    	$order->status = 0;
    	$order->save();

    	// show a success message
        \Alert::success('The Computer has been added successfully.')->flash();

    	return redirect()->route('order.index');

    }

    public function edit($id){
    	abort_if(Auth::user()->user_type == 1, 404);

    	$order = Order::find($id);
    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();

    	return view('personnel.request.edit')
    		->with('order', $order)
    		->with('rooms', $rooms);
    }

        public function update(Request $request, $id) {
    	abort_if(Auth::user()->user_type == 1, 404);
    	if($request->nature == "0"){
    	$this->validate($request, [
    		'room' => 'required',
    		'nature' => 'required|not_in:none',
    		'others' => 'required',
    		'order' => 'required'
    	]);
    	}else{
    		$this->validate($request, [
    		'room' => 'required',
    		'nature' => 'required|not_in:none',
    		'order' => 'required'
    	]);
    	}


    	$order = Order::find($id);
    	$order->building_id = Auth::user()->building_id;
    	$order->room_id = $request->room;
    	if($request->nature != "0"){
    	$order->nature = $request->nature;
    	}else{
    	$order->nature = $request->others;		
    	}
    	$order->request = $request->order;
    	$order->action_taken = $request->action;
    	$order->prepared_by = Auth::user()->name;
    	$order->status = 0;
    	$order->save();

    	// show a success message
        \Alert::success('The Computer has been added successfully.')->flash();

    	return redirect()->route('order.index');

    }
}
