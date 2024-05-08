<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Request;
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
            'data'  => [],
            'state' => false
        ];
        $stCod = 200;

        try {

            \DB::beginTransaction();
            
            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->index();

            \DB::commit();

            if((!$response) || !(count($response) > 0)){
                $stCod = 404;
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  =true;

            return response()->json($dataToReturn, $stCod);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            return response()->json($dataToReturn, 500);
            
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataToReturn = [
            'data'  => [],
            'status'=> false
        ];

        try {

            \DB::beginTransaction();

            $data = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $response       = $storeDomainObj->create($data);

            \DB::commit();


            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            //$msg  = $e->getMessage().' - '.$e->getLine().' - '.$e->getFile();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataToReturn = [
            'data'  => [],
            'status'=> false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->show($id);

            \DB::commit();
            if(!$response){
                $stCod = 404;
            }
            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, $stCod);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataToReturn = [
            'data'      => [],
            'status'    => false
        ];

        try {

            \DB::beginTransaction();


            $data = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->update($id, $data);


            \DB::commit();

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 200);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            return response()->json($dataToReturn, 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataToReturn = [
            'data'      => [],
            'status'    => false
        ];
        
        try {

            \DB::beginTransaction();
     
            
            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->destroy($id);


            \DB::commit();

            $dataToReturn['data']   = 'Store removed successfully';
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 204);

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 400);

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            return response()->json($dataToReturn, 500);

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            return response()->json($dataToReturn, 500);
            
        }
    }
}
