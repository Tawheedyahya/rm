<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tablerequest;
use App\Models\Table;
use App\Policies\TablePolicy;
use App\Services\Tableservice;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
#[Group('TABLE')]
class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $tableservice;
    public function __construct(Tableservice $tableservice) {
        $this->tableservice=$tableservice;
    }
    /**
     * DISPLAY A TABLE
     */
    public function index()
    {
        //
        $tables=$this->tableservice->index();
        if($tables['success']){
            return response()->json($tables,$tables['status']); 
        }
        else{
            return response()->json($tables,$tables['status']);
        }
    }

    /**
     * CREATE A TABLE
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
     * UPDATE TABLE
     */
    public function update(Tablerequest $request, Table $table)
    {
    Gate::authorize('update', $table); // throws 403 if denied
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
    }
}
