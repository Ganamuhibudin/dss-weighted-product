<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\SubCriteria;
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
                    'action' => '<a href="/criteria/'.$value['id'].'" class="btn btn-warning btn-sm" style="color: white;"><i class="fas fa-edit"></i> Ubah</a>&nbsp;<button url="/criteria/'.$value['id'].'" class="btn btn-danger btn-sm btn-delete" style="color: white;"><i class="fas fa-trash"></i> Hapus</button>&nbsp;<a href="/criteria/list-sub/'.$value['id'].'" class="btn btn-info btn-sm" style="color: white;"><i class="fas fa-edit"></i> Subkriteria</a>',
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
        $criteria = new Criteria;

        $criteria->code     = $request->code;
        $criteria->name     = $request->name;
        $criteria->atribut  = $request->atribut;
        $criteria->weight   = $request->weight;
        $criteria->save();

        return response()->json($criteria, 201);
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

    // Function to show list of sub criteria
    public function listSub(Request $request, $criteriaID)
    {
        $criteria = Criteria::find($criteriaID);

        // redirect if criteria doesn't exist
        if ($criteria === null) {
            return redirect('/criteria');
        }

        if ($request->ajax()) {
            $getSubCriterias = SubCriteria::select('criteria_id', 'value', 'name', 'id')
                ->where('criteria_id', $criteriaID)
                ->get()
                ->toArray();

            $subs = [];
            $idx = 1;
            foreach ($getSubCriterias as $row) {
                $subs[] = [
                    'id'            => $row['id'],
                    'no'            => $idx,
                    'name'          => $row['name'],
                    'criteria_id'   => $row['criteria_id'],
                    'value'         => $row['value'],
                    'action'        => '<button url="/criteria/sub/'.$row['id'].'" class="btn btn-warning btn-sm btn-edit" style="color: white;width: fit-content;"><i class="fas fa-edit"></i> Ubah</button>&nbsp;<button url="/criteria/sub/delete/'.$row['id'].'" class="btn btn-danger btn-sm btn-delete" style="color: white;width: fit-content;"><i class="fas fa-trash"></i> Hapus</button>',
                ];
                $idx++;
            }

            return response()->json($subs);
        }
        
        return view('criterias/list-subs')->with('criteria', $criteria->toArray());
    }

    // Function to handle create sub criteria
    public function addSub(Request $request)
    {
        $subCriteria = new SubCriteria;

        $subCriteria->criteria_id   = $request->criteria_id;
        $subCriteria->name          = $request->name;
        $subCriteria->value         = $request->value;
        $subCriteria->save();

        return response()->json($subCriteria, 201);
    }

    // Function to handle get sub criteria
    public function getSub($id)
    {
        $subCriteria = SubCriteria::find($id);

        return response()->json($subCriteria->toArray(), 200);
    }

    // Function to handle update sub criteria
    public function updateSub(Request $request, $id)
    {
        $subCriteria = SubCriteria::find($id);

        $subCriteria->name  = $request->name;
        $subCriteria->value = $request->value;
        if (!$subCriteria->save()) {
            return response()->json($subCriteria, 500);
        }

        return response()->json($subCriteria, 200);
    }

    // Function to handle delete sub criteria
    public function deleteSub($id)
    {
        $subCriteria = SubCriteria::find($id);
        $subCriteria->delete();

        return response()->json($subCriteria, 200);
    }
}
