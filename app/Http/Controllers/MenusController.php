<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Validator;

class MenusController extends Controller
{
    public function index()
    {
        // Run query based on location ( longitude and latitude range ) later.

        $menu = Menu::all();
        if (!$menu) {
            return $this->customResponse('404', 'There are no Menus');
        }
        return $this->customResponse('200', 'Menu Found!', $menu);

    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required | min:6',
            'vendor_id'=> 'required',
        ]);

        if ($validator->fails()) {
            return $this->customResponse('400', 'Validation failed.', $validator->errors());
        }

        $menu = Menu::create(request()->all());
        if ($menu) {
            return $this->customResponse('200', 'Menu Created Successfully');
        }
        return $this->customResponse('500', 'Menu not saved, Something went wrong.');

    }

    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu)  {
           return $this->response('404', 'Menu not found');
        }
        return $this->response('200', 'Menu found.', $menu);
    }

    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required | min:6',
        ]);

        if ($validator->fails()) {
            return $this->customResponse('400', 'Validation failed.', $validator->errors());
        }

        $menu = Menu::find($id);
        if (count($menu) < 1) {
            return $this->customResponse('404', 'Menu not found.');
        }

        $menu->update(request()->all());
        return $this->customResponse('200', 'Menu Updated successfully.', $menu);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (count($menu) < 1) {
            return $this->customResponse('200', 'Menu not found.');
        }
        $menu->delete();
        return $this->customResponse('200', 'Menu deleted Successfully.');

    }

    public function customResponse($code, $message = null, $data = [])
    {
        return response()->json([
            'responseMessage' => $message ?? 'Here are a list of Menus.',
            'responseCode' => $code ?? '200',
            'data' => $data
        ], 200);
    }
}
