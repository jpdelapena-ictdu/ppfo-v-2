<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use Auth;
use App\Building;
use App\Computer;
use App\Component;
use App\Room;

class ItemPersonnelController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 1, 404);

        $building = Building::find(Auth::user()->building_id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::all();
        $items = Item::all();
        $itemArr = [];
        $x = 0;

        foreach ($rooms as $room) {
          foreach ($items as $item) {
             if ($item->room_id == $room->id) {
                $itemArr[$x++] = [
                   'id' => $item->id,
                   'building_id' => $building->id,
                   'building' => $building->name,
                   'room_id' => $item->room_id,
                   'room' => $room->name,
                   'category' => $item->category,
                   'description' => $item->description,
                   'brand' => $item->brand,
                   'serial' =>$item->serial,
                   'date_purchased' => $item->date_purchased,
                   'amount' => $item->amount,
                   'date_issued' => $item->date_issued,
                   'quantity' => $item->quantity,
                   'working' => $item->working,
                   'not_working' => $item->not_working,
                   'for_repair' => $item->for_repair,
                   'for_calibrate' => $item->for_calibrate,
                   'remarks' => $item->remarks,
                   'created_at' => $item->created_at,
                   'updated_at' => $item->updated_at
               ];
           }
   }
}

$itemArr = json_decode(json_encode($itemArr));

return view('personnel.item.index')
->with('items', $itemArr)
->with('building', $building);
}

    public function create() {
        abort_if(Auth::user()->user_type == 1, 404);

    	$building = Building::find(Auth::user()->building_id);
    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();

    	return view('personnel.item.create')
    		->with('building', $building)
    		->with('rooms', $rooms);
    }

    public function store(Request $request) {
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

                return redirect()->route('personnel.computer.index');
            }
        }
        $this->validate($request, [
            'room' => 'required',
            'description' => 'required',
            'brand' => 'required',
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
        $item->room_id = $request->room;
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

        return redirect()->route('item.personnel.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 1, 404);

    	$item = Item::find($id);
    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();

    	return view('personnel.item.edit')
    		->with('rooms', $rooms)
    		->with('item', $item);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);
        if($request->category != 'none'){
            if($request->category == 0){

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
                $item = Item::find($id);
                $item->delete();
                \Alert::success('Computer has been successfully added.')->flash();

                return redirect()->route('personnel.computer.index');
            }

        }
    	$this->validate($request, [
            'room' => 'required|not_in:none',
            'description' => 'required',
            'brand' => 'required',
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

        $item = Item::find($id);
        $item->room_id = $request->room;
        $item->category = $request->category;
        $item->brand = $request->brand;
        $item->description = $request->description;
        $item->quantity = $request->quantity;
        $item->serial = $request->serial;
        $item->date_purchased = $request->date_purchased;
        $item->amount = $request->amount;
        $item->date_issued = $request->date_issued;
        $item->working = $request->working;
        $item->not_working = $request->not_working;
        $item->for_repair = $request->for_repair;
        $item->for_calibrate = $request->for_calibrate;
        $item->remarks = $request->remarks;
        $item->save();


    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('item.personnel.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 1, 404);
        
    	$item = Item::find($id);
    	$item->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->back();
    }
}
