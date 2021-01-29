<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\Customers;
use App\Models\CustomerValues;
use Auth;

class CustomerValueController extends Controller
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
        // get customers
        $getCustomers = Customers::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $customers = [];
        foreach ($getCustomers as $value) {
            $customers[$value['id']] = $value;
        }

        // get criteria
        $getCriterias = Criteria::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $criterias = [];
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
        }

        // get customer values
        $getCustomerValues = CustomerValues::select('id', 'customer_id', 'criteria_id', 'value')
            ->get()
            ->toArray();

        $customerValues = [];
        foreach ($getCustomerValues as $value) {
            $customerValues[$value['customer_id']]['customer'] = $customers[$value['customer_id']];
            $customerValues[$value['customer_id']]['values'][$value['criteria_id']] = [
                'value' => $value['value'],
            ];
        }

        return view('customers/value')
            ->with('criterias', $criterias)
            ->with('customerValues', $customerValues);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get customers
        $getCustomers = Customers::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $customers = [];
        foreach ($getCustomers as $value) {
            $customers[$value['id']] = $value;
        }

        // get criteria
        $getCriterias = Criteria::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $criterias = [];
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
        }
        
        // get sub criteria
        $getSubCriterias = SubCriteria::select('id', 'criteria_id', 'name', 'value')
            ->get()
            ->toArray();
        
        $subCriterias = [];
        foreach ($getSubCriterias as $value) {
            $subCriterias[$value['criteria_id']][] = $value;
        }

        return view('customers/appraisal')
            ->with('customers', $customers)
            ->with('subCriterias', $subCriterias)
            ->with('criterias', $criterias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get customer values
        $customerID = $request->get('customer');
        $getCustomerValues = CustomerValues::select('id', 'customer_id', 'criteria_id', 'value')
            ->where('customer_id', $customerID)
            ->get()
            ->toArray();

        if (count($getCustomerValues) > 0) {
            return response()->json(['message' => 'Data penilaian pelanggan sudah tersimpan'], 400);
        }

        // get criteria
        $getCriterias = Criteria::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $criterias = [];
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
        }
        
        foreach ($criterias as $key => $value) {
            $customerValue = new CustomerValues;

            $customerValue->customer_id = $customerID;
            $customerValue->criteria_id = $key;
            $customerValue->value       = $request->values[$key];
            $customerValue->save();
        }
        return response()->json($customerID, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get customers
        $getCustomers = Customers::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $customers = [];
        foreach ($getCustomers as $value) {
            $customers[$value['id']] = $value;
        }

        // get criteria
        $getCriterias = Criteria::select('id', 'code', 'name')
            ->get()
            ->toArray();

        $criterias = [];
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
        }

        // get customer values
        $getCustomerValues = CustomerValues::select('id', 'customer_id', 'criteria_id', 'value')
            ->where('customer_id', $id)
            ->get()
            ->toArray();

        $customerValues = [];
        foreach ($getCustomerValues as $value) {
            $customerValues['customer'] = $customers[$value['customer_id']];
            $customerValues['values'][$value['criteria_id']] = [
                'value' => $value['value'],
            ];
        }
        
        // get sub criteria
        $getSubCriterias = SubCriteria::select('id', 'criteria_id', 'name', 'value')
            ->get()
            ->toArray();
        
        $subCriterias = [];
        foreach ($getSubCriterias as $value) {
            $subCriterias[$value['criteria_id']][] = $value;
        }

        return view('customers/appraisal')
            ->with('criterias', $criterias)
            ->with('subCriterias', $subCriterias)
            ->with('customerValues', $customerValues);
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
        $inputCustomerValue = $request->get('values');

        // get customer values data
        $getCustomerValues = CustomerValues::select('id', 'customer_id', 'criteria_id', 'value')
            ->where('customer_id', $id)
            ->get()
            ->toArray();
    
        foreach ($getCustomerValues as $data) {
            $update = CustomerValues::where('id', $data['id'])
                ->update(['value' => $inputCustomerValue[$data['criteria_id']]]);
        }
        
        return response()->json(['message' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
