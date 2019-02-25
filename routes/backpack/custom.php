<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

	// user routes
	Route::get('users', 'UserController@index')->name('user.index');
	Route::get('users/create', 'UserController@create')->name('user.create');
	Route::post('users/create', 'UserController@store')->name('user.store');
	Route::get('users/{id}/edit', 'UserController@edit')->name('user.edit');
	Route::match(['PUT', 'PATCH'], 'users/{id}/edit', 'UserController@update')->name('user.update');
	Route::get('users/{id}/edit-status', 'UserController@updateStatus')->name('user.update-status');
	// Route::delete('users/{id}/delete', 'UserController@destroy')->name('user.destroy');

	// building routes
	Route::get('buildings', 'BuildingController@index')->name('building.index');
	Route::get('buildings/create', 'BuildingController@create')->name('building.create');
	Route::post('buildings/create', 'BuildingController@store')->name('building.store');
	Route::get('buildings/{id}/edit', 'BuildingController@edit')->name('building.edit');
	Route::get('buildings/{id}/show', 'BuildingController@show')->name('building.show');
	Route::match(['PUT', 'PATCH'], 'buildings/{id}/edit', 'BuildingController@update')->name('building.update');
	Route::delete('buildings/{id}/delete', 'BuildingController@destroy')->name('building.destroy');

	// room routes
	Route::get('rooms', 'RoomController@index')->name('room.index');
	Route::get('rooms/create', 'RoomController@create')->name('room.create');
	Route::post('rooms/create', 'RoomController@store')->name('room.store');
	Route::get('rooms/{id}/edit', 'RoomController@edit')->name('room.edit');
	Route::get('rooms/{id}/show', 'RoomController@show')->name('room.show');
	Route::match(['PUT', 'PATCH'], 'rooms/{id}/edit', 'RoomController@update')->name('room.update');
	Route::delete('rooms/{id}/delete', 'RoomController@destroy')->name('room.destroy');

	// item routes
	Route::get('items', 'ItemController@index')->name('item.index');
	Route::get('items/create', 'ItemController@create')->name('item.create');
	Route::post('items/create', 'ItemController@store')->name('item.store');
	Route::get('items/{id}/edit', 'ItemController@edit')->name('item.edit');
	Route::match(['PUT', 'PATCH'], 'items/{id}/edit', 'ItemController@update')->name('item.update');
	Route::delete('items/{id}/delete', 'ItemController@destroy')->name('item.destroy');
	// Route::get('items/show', 'ItemController@show')->name('item.show');

	// fixture routes
	Route::get('fixtures', 'FixtureController@index')->name('fixture.index');
	Route::get('fixtures/create', 'FixtureController@create')->name('fixture.create');
	Route::post('fixtures/create', 'FixtureController@store')->name('fixture.store');
	Route::get('fixtures/{id}/edit', 'FixtureController@edit')->name('fixture.edit');
	Route::match(['PUT', 'PATCH'], 'fixtures/{id}/edit', 'FixtureController@update')->name('fixture.update');
	Route::delete('fixtures/{id}/delete', 'FixtureController@destroy')->name('fixture.destroy');

	// report routes
	Route::get('items/download', 'ItemController@downloadItem')->name('download.item');
	Route::get('rooms/{id}/items/download', 'RoomController@downloadItem')->name('room.download.item');


	// Personnel Routes
	// room
	Route::get('rooms/personnel', 'RoomPersonnelController@index')->name('room.personnel.index');
	Route::get('rooms/personnel/create', 'RoomPersonnelController@create')->name('room.personnel.create');
	Route::post('rooms/personnel/create', 'RoomPersonnelController@store')->name('room.personnel.store');
	Route::get('rooms/personnel/{id}/edit', 'RoomPersonnelController@edit')->name('room.personnel.edit');
	Route::get('rooms/personnel/{id}/show', 'RoomPersonnelController@show')->name('room.personnel.show');
	Route::match(['PUT', 'PATCH'], 'rooms/personnel/{id}/edit', 'RoomPersonnelController@update')->name('room.personnel.update');
	Route::delete('rooms/personnel/{id}/delete', 'RoomPersonnelController@destroy')->name('room.personnel.destroy');

	// add item in chosen room
	Route::get('rooms/personnel/{id}/item/create', 'RoomPersonnelController@createItemInRoom')->name('room.personnel.create.item');
	Route::post('rooms/personnel/{id}/item/create', 'RoomPersonnelController@storeItemInRoom')->name('room.personnel.store.item');

	// item
	Route::get('items/personnel', 'ItemPersonnelController@index')->name('item.personnel.index');
	Route::get('items/personnel/create', 'ItemPersonnelController@create')->name('item.personnel.create');
	Route::post('items/personnel/create', 'ItemPersonnelController@store')->name('item.personnel.store');
	Route::get('items/personnel/{id}/edit', 'ItemPersonnelController@edit')->name('item.personnel.edit');
	Route::get('items/personnel/{id}/show', 'ItemPersonnelController@show')->name('item.personnel.show');
	Route::match(['PUT', 'PATCH'], 'items/personnel/{id}/edit', 'ItemPersonnelController@update')->name('item.personnel.update');
	Route::delete('items/personnel/{id}/delete', 'ItemPersonnelController@destroy')->name('item.personnel.destroy');

	// report routes
	Route::get('rooms/{id}/personnel/items/download', 'RoomPersonnelController@downloadItem')->name('room.personnel.download.item');

	//computer routes
	Route::get('admin/computers', 'ComputerController@index')->name('computer.index');
	Route::get('admin/computers/create', 'ComputerController@create')->name('computer.create');
	Route::post('admin/computers/create', 'ComputerController@store')->name('computer.store');
	Route::get('admin/computers/{id}/edit', 'ComputerController@edit')->name('computer.edit');
	Route::match(['PUT', 'PATCH'], 'admin/computers/{id}/edit', 'ComputerController@update')->name('computer.update');
	Route::delete('admin/computers/{id}/delete', 'ComputerController@destroy')->name('computer.destroy');



}); // this should be the absolute last line of this file