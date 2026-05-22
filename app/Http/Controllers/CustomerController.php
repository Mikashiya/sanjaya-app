<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::all();

        return view('pelanggan', compact('customers'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required'],
            'phone_no' => ['required', 'integer'],
            'address' => [''],
        ]);

        if (Customer::create($data)) {
            return back();
        }

        return back()->withErrors([

        ]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'name' => ['required'],
            'phone_no' => ['required'],
            'address' => [''],
        ]);

        if (Customer::where('id', $request->id)->update($data)) {
            return back();
        }

        return back()->withErrors([

        ]);
    }

    public function delete(Request $request) {
        Customer::destroy($request->id);

        return back();
    }
}
