<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use Validator;

class VendorsController extends Controller
{
    public function index()
    {
        // Run query based on location ( longitude and latitude range ) later.

        $vendors = Vendor::with('menu')->get();
        if (count($vendors)<1) {
           return $this->customResponse('404', 'There are no vendors');
        }
        return $this->customResponse('200', 'Vendor Found!', $vendors);

    }

    public function store()
    {
        
        $validator = Validator::make(request()->all(), [
            'name'=> 'required | min:6',
            'location'=> 'required',
            'phone_number'=> 'required | digits_between:10,13 | unique:vendors,phone_number'
        ]);

        if ($validator->fails()) {
           
            return $this->customResponse('400', 'Validation failed.', $validator->errors());
        }
        
        $vendor = Vendor::create(request()->all());
        if ($vendor) {
            return $this->customResponse('200', 'Vendor Created Successfully');
        }
        return $this->customResponse('500', 'Vendor not saved, Something went wrong');
        
    }

    public function update($id)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required | min:6',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->customResponse('400', 'Validation failed.', $validator->errors()->toArray());
        }

        $vendor = Vendor::find($id);
        if (count($vendor)< 1) {
            return $this->customResponse('404', 'Vendor not found');
        }

        $vendor->update(request()->except('phone_number'));
        return $this->customResponse('200', 'Vendor Updated successfully.', $vendor);
    }

    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        if (count($vendor)< 1) {
            return $this->customResponse('200', 'Vendor not found.');
        }
        $vendor->delete();
        return $this->customResponse('200', 'Vendor deleted Successfully.');

    }
    
    public function customResponse($code, $message = null, $data = [])
    {
        return response()->json([
            'responseMessage' => $message ?? 'Here are a list of Vendors.',
            'responseCode' => $code ?? '200',
            'data' => $data
        ], 200);
    }
}
