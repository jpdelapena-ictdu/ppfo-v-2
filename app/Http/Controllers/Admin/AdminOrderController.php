<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use App\Order;
use App\Room;
use App\Building;

class AdminOrderController extends Controller
{
     public function index() {
    	abort_if(Auth::user()->user_type == 2, 404);

    	$orders = Order::orderBy('updated_at', 'desc')->get();
    	$reqArr = [];
    	$x = 0;

    	foreach ($orders as $row) {
    		$room = Room::find($row->room_id);
            $building = Building::find($row->building_id);
    		$reqArr[$x++] = [
    			'id' => $row->id,
                'building' => $building->name,
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

    	return view('admin.request.index')
    		->with('orders', $reqArr);

    }

    public function approve($id){
        $orders = Order::find($id);
        $orders->status = 1;
        $orders->save();

        return redirect()->back();
    }

    public function reject($id){
        $orders = Order::find($id);
        $orders->status = 2;
        $orders->save();

        return redirect()->back();
    }
}
