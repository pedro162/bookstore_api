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
        $dataToReturn = [
            'data'=>    null,
            'status'=>  false
        ];

        try {

            \DB::beginTransaction();
            
            $storeDomainObj = new StoreDomain();
            $respone = $storeDomainObj->index();

            \DB::commit();


            $dataToReturn['data']   =>$respone;
            $dataToReturn['state']  =>true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;
            return response()->json($dataToReturn, 500);
            
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataToReturn = [
            'data'=>    null,
            'status'=>  false
        ];

        try {

            \DB::beginTransaction();

            $dados = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $respone = $storeDomainObj->create($dados);

            \DB::commit();


            $dataToReturn['data']   =>$respone;
            $dataToReturn['state']  =>true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataToReturn = [
            'data'=>    null,
            'status'=>  false
        ];

        try {

            \DB::beginTransaction();

            $storeDomainObj = new StoreDomain();
            $respone = $storeDomainObj->show($id);

            \DB::commit();

            $dataToReturn['data']   =>$respone;
            $dataToReturn['state']  =>true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataToReturn = [
            'data'=>    null,
            'status'=>  false
        ];

        try {

            \DB::beginTransaction();


            $dados = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $respone = $storeDomainObj->update($id, $dados);


            \DB::commit();

            $dataToReturn['data']   =>$respone;
            $dataToReturn['state']  =>true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataToReturn = [
            'data'=>    null,
            'status'=>  false
        ];
        
        try {

            \DB::beginTransaction();


            $dados = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $respone = $storeDomainObj->destroy($id);


            \DB::commit();

            $dataToReturn['data']   =>'Store removed successfully';
            $dataToReturn['state']  =>true;

            return response()->json($dataToReturn, 204);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   =>$msg;
            $dataToReturn['state']  =>false;
            return response()->json($dataToReturn, 500);
            
        }
    }
}
