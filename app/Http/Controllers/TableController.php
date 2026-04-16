<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tablerequest;
use App\Models\Table;
use App\Services\Tableservice;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tableservice;
    public function __construct(Tableservice $tableservice) {
        $this->tableservice=$tableservice;
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Tablerequest $request)
    {
        $table=$this->tableservice->store($request->validated());
        if($table['success']){
            return response()->json($table,$table['status']);
        }
        else{
            return response()->json($table,$table['status']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
    }
}
