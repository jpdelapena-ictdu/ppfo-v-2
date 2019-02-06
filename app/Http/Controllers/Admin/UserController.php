<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Building;
use Auth;

class UserController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$users = User::where('user_type', '=', 2)->orderBy('updated_at', 'desc')->get();
    	$userArr = [];
    	$x = 0;
    	foreach ($users as $row) {
    		$building = Building::find($row->building_id);
    		$userArr[$x++] = [
    			'id' => $row->id,
    			'name' => $row->name,
    			'email' => $row->email,
    			'user_type' => $row->user_type,
    			'status' => $row->status,
    			'building_id' => $row->building_id,
    			'building' => '(' .$building->short_name. ') ' .$building->name,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at
    		];
    	}

    	$userArr = json_decode(json_encode($userArr));

    	return view('admin.user.index')
    		->with('users', $userArr);
    }

    public function create() {
        abort_if(Auth::user()->user_type == 2, 404);

    	$buildings = Building::orderBy('created_at', 'desc')->get();

    	return view('admin.user.create')
    		->with('buildings', $buildings);
    }

    public function store(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'name' => 'required|max:191',
    		'email' => 'required|email|unique:users,email',
    		'building_id' => 'required'
    	]);

    	$user = New User;
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->building_id = $request->building_id;
    	$user->status = 'active';
    	$user->user_type = 2;
    	$user->password = bcrypt('123456789');
    	$user->save();

    	// show a success message
        \Alert::success('The item has been added successfully.')->flash();

    	return redirect()->route('user.index');
    }

    public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$user = User::find($id);
    	$buildings = Building::orderBy('created_at', 'desc')->get();

    	return view('admin.user.edit')
    		->with('user', $user)
    		->with('buildings', $buildings);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$user = User::find($id);

    	if ($user->email == $request->email) {
    		$this->validate($request, [
	    		'name' => 'required|max:191',
	    		'building_id' => 'required'
	    	]);
    	} else {
    		$this->validate($request, [
	    		'name' => 'required|max:191',
	    		'email' => 'required|email|unique:users,email',
	    		'building_id' => 'required'
	    	]);
    	}

    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->building_id = $request->building_id;
    	$user->save();

    	// show a success message
        \Alert::success('The item has been modified successfully.!')->flash();

    	return redirect()->route('user.index');
    }

    public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);

    	$user = User::find($id);
    	$user->delete();

    	// show a success message
        \Alert::success('Item has been deleted.')->flash();

        return redirect()->route('user.index');
    }

    public function updateStatus($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
        $user = User::find($id);
        if ($user->status == 'active') {
            $user->status = 'inactive';
            $user->save();

            // show a success message
            \Alert::success('The item has been modified successfully.!')->flash();

            return redirect()->route('user.index');
        } else {
            $user->status = 'active';
            $user->save();

            // show a success message
            \Alert::success('The item has been modified successfully.!')->flash();

            return redirect()->route('user.index');
        }
    }
}
