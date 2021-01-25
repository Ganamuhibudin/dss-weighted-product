<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\Customers;
use App\Models\CustomerValues;
use Auth;
use PDF;

class CalculationController extends Controller
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
    public function index()
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
        $getCriterias = Criteria::select('id', 'code', 'name', 'weight')
            ->get()
            ->toArray();

        $criterias = [];
        $totalNilaiKriteria = 0;
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
            $totalNilaiKriteria = $totalNilaiKriteria + $value['weight'];
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

        // normalisasi nilai bobot
        $normalisasiBobot = [];
        $totalBobot = 0;
        foreach ($criterias as $criteria) {
            $bobot = round(($criteria['weight']/$totalNilaiKriteria), 2);
            $totalBobot = $totalBobot + $bobot;
            $normalisasiBobot[] = [
                'code' => str_replace("K", "W", $criteria['code']),
                'value' => $bobot
            ];
        }

        // nilai vector S
        $nilaiVectorS = [];
        foreach ($customerValues as $row) {
            $i = 0;
            $critWeight = [];
            foreach ($row['values'] as $val) {
                $weight = $val['value'];
                $nb = $normalisasiBobot[$i]['value'];
                $critWeight[] = pow($weight, $nb);
                $i++;
            }
            $calculate = 1;
            for ($j=0; $j < count($critWeight); $j++) { 
                $calculate = $calculate * $critWeight[$j];
            }
            $calculate = round($calculate, 2);
            $nilaiVectorS[] = $calculate;
        }
        $totalVectorS = array_sum($nilaiVectorS);

        // nilai vector V
        $nilaiVectorV = [];
        foreach ($nilaiVectorS as $vectorS) {
            $nv = $vectorS / $totalVectorS;
            $nv = round($nv, 2);
            $nilaiVectorV[] = $nv;
        }

        $rank = $nilaiVectorV;
        rsort($rank);

        return view('customers/calculation')
            ->with('customers', $customers)
            ->with('criterias', $criterias)
            ->with('normalisasiBobot', $normalisasiBobot)
            ->with('totalBobot', $totalBobot)
            ->with('nilaiVectorS', $nilaiVectorS)
            ->with('totalVectorS', $totalVectorS)
            ->with('nilaiVectorV', $nilaiVectorV)
            ->with('rank', $rank)
            ->with('customerValues', $customerValues);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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

    // function to handle report index page
    public function reports()
    {
        return view('reports/index');
    }

    // function to handle print all customers report
    public function printAllCustomerReport()
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
        $getCriterias = Criteria::select('id', 'code', 'name', 'weight')
            ->get()
            ->toArray();

        $criterias = [];
        $totalNilaiKriteria = 0;
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
            $totalNilaiKriteria = $totalNilaiKriteria + $value['weight'];
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

        // normalisasi nilai bobot
        $normalisasiBobot = [];
        $totalBobot = 0;
        foreach ($criterias as $criteria) {
            $bobot = round(($criteria['weight']/$totalNilaiKriteria), 2);
            $totalBobot = $totalBobot + $bobot;
            $normalisasiBobot[] = [
                'code' => str_replace("K", "W", $criteria['code']),
                'value' => $bobot
            ];
        }

        // nilai vector S
        $nilaiVectorS = [];
        foreach ($customerValues as $row) {
            $i = 0;
            $critWeight = [];
            foreach ($row['values'] as $val) {
                $weight = $val['value'];
                $nb = $normalisasiBobot[$i]['value'];
                $critWeight[] = pow($weight, $nb);
                $i++;
            }
            $calculate = 1;
            for ($j=0; $j < count($critWeight); $j++) { 
                $calculate = $calculate * $critWeight[$j];
            }
            $calculate = round($calculate, 2);
            $nilaiVectorS[] = $calculate;
        }
        $totalVectorS = array_sum($nilaiVectorS);

        // nilai vector V
        $nilaiVectorV = [];
        foreach ($nilaiVectorS as $vectorS) {
            $nv = $vectorS / $totalVectorS;
            $nv = round($nv, 2);
            $nilaiVectorV[] = $nv;
        }

        $rank = $nilaiVectorV;
        rsort($rank);
 
    	$pdf = PDF::loadview('/reports/all',[
            'customers' => $customers,
            'nilaiVectorV' => $nilaiVectorV,
            'rank' => $rank
        ]);
    	return $pdf->download('report-all-customers.pdf');
    }

    // function to handle print rank customers report
    public function printRankCustomerReport()
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
        $getCriterias = Criteria::select('id', 'code', 'name', 'weight')
            ->get()
            ->toArray();

        $criterias = [];
        $totalNilaiKriteria = 0;
        foreach ($getCriterias as $value) {
            $criterias[$value['id']] = $value;
            $totalNilaiKriteria = $totalNilaiKriteria + $value['weight'];
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

        // normalisasi nilai bobot
        $normalisasiBobot = [];
        $totalBobot = 0;
        foreach ($criterias as $criteria) {
            $bobot = round(($criteria['weight']/$totalNilaiKriteria), 2);
            $totalBobot = $totalBobot + $bobot;
            $normalisasiBobot[] = [
                'code' => str_replace("K", "W", $criteria['code']),
                'value' => $bobot
            ];
        }

        // nilai vector S
        $nilaiVectorS = [];
        foreach ($customerValues as $row) {
            $i = 0;
            $critWeight = [];
            foreach ($row['values'] as $val) {
                $weight = $val['value'];
                $nb = $normalisasiBobot[$i]['value'];
                $critWeight[] = pow($weight, $nb);
                $i++;
            }
            $calculate = 1;
            for ($j=0; $j < count($critWeight); $j++) { 
                $calculate = $calculate * $critWeight[$j];
            }
            $calculate = round($calculate, 2);
            $nilaiVectorS[] = $calculate;
        }
        $totalVectorS = array_sum($nilaiVectorS);

        // nilai vector V
        $nilaiVectorV = [];
        $custVal = [];
        $idx = 0;
        foreach ($nilaiVectorS as $vectorS) {
            $nv = $vectorS / $totalVectorS;
            $nv = round($nv, 2);
            $nilaiVectorV[] = $nv;
            $custVal[] = [
                'id' => $getCustomers[$idx]['id'],
                'name' => $getCustomers[$idx]['name'],
                'value' => $nv
            ];
            $idx++;
        }

        $rankValue = array_column($custVal, 'value');
        array_multisort($rankValue, SORT_DESC, $custVal);
 
    	$pdf = PDF::loadview('/reports/rank',[
            'data' => $custVal
        ]);
    	return $pdf->download('report-rank-customers.pdf');
    }
}
