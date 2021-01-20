<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use Auth;

class CriteriaController extends Controller
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
            $getCriterias = Criteria::select('code', 'name', 'atribut', 'weight', 'id')
                ->get()
                ->toArray();

            $criterias = [];
            foreach ($getCriterias as $value) {
                $criterias[] = [
                    'id' => $value['id'],
                    'code' => $value['code'],
                    'name' => $value['name'],
                    'atribut' => ucfirst($value['atribut']),
                    'weight' => $value['weight'],
                    'action' => '<a href="/criteria/'.$value['id'].'" class="btn btn-block btn-warning btn-sm" style="color: white;"><i class="fas fa-edit"></i></a><button url="/criteria/'.$value['id'].'" class="btn btn-block btn-danger btn-sm btn-delete" style="color: white;"><i class="fas fa-trash"></i></button>',
                ];
            }

            return response()->json($criterias);
        }
        
        return view('criterias/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('criterias/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Criteria;

        $customer->code     = $request->code;
        $customer->name     = $request->name;
        $customer->atribut  = $request->atribut;
        $customer->weight    = $request->weight;
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
        $criteria = Criteria::select('code', 'name', 'atribut', 'weight', 'id')
            ->find($id)
            ->toArray();

        return view('criterias/form')->with('criteria', $criteria);
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
        $criteria = Criteria::find($id);

        $criteria->code     = $request->code;
        $criteria->name     = $request->name;
        $criteria->atribut  = $request->atribut;
        $criteria->weight   = $request->weight;
        if (!$criteria->save()) {
            return response()->json($criteria, 400);
        }

        return response()->json($criteria, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria = Criteria::find($id);
        $criteria->delete();

        return response()->json($criteria, 200);
    }
}
