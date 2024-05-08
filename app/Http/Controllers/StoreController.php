<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\StoreDomain;
use App\Exceptions\StoreException;

class StoreController extends Controller
{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $dados = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $storeDomainObj->create($dados);

        } catch (StoreException $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 401);

        }catch (\Exception $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 500);

        }catch (\Error $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 500);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $dados = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $storeDomainObj->update($id, $dados);

        } catch (StoreException $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 401);

        }catch (\Exception $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 500);

        }catch (\Error $e) {
            $msg  = $e->getMessage();
            return response()->json(['error' => $msg], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
