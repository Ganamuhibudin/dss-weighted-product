<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;
use Auth;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $getCustomers = Customers::select('code', 'name', 'address', 'phone', 'id')
                ->get()
                ->toArray();

            $customers = [];
            foreach ($getCustomers as $value) {
                $customers[] = [
                    'id' => $value['id'],
                    'code' => $value['code'],
                    'name' => $value['name'],
                    'address' => $value['address'],
                    'phone' => $value['phone'],
                    'action' => '<a href="/customers/'.$value['id'].'" class="btn btn-block btn-warning btn-sm" style="color: white;"><i class="fas fa-edit"></i></a><button url="/customers/'.$value['id'].'" class="btn btn-block btn-danger btn-sm btn-delete" style="color: white;"><i class="fas fa-trash"></i></button>',
                ];
            }

            return response()->json($customers);
        }
        
        return view('customers/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customers;

        $customer->code     = $request->code;
        $customer->name     = $request->name;
        $customer->address  = $request->address;
        $customer->phone    = $request->phone;
        $customer->save();

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customers::select('code', 'name', 'address', 'phone', 'id')
            ->find($id)
            ->toArray();

        return view('customers/form')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customers::find($id);

        $customer->code     = $request->code;
        $customer->name     = $request->name;
        $customer->address  = $request->address;
        $customer->phone    = $request->phone;
        if (!$customer->save()) {
            return response()->json($customer, 400);
        }

        return response()->json($customer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customers::find($id);
        $customer->delete();

        return response()->json($customer, 200);
    }
}
