<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Request;
use Illuminate\Http\Request;
use App\Domain\StoreDomain;
use App\Exceptions\StoreException;
use App\Builder\StoreBuilder;

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
        
        $objBuilder         = new StoreBuilder();
        $dataToReturn       = $objBuilder->index();

        $httpResposeCode = $objBuilder->getHttpResponseCode();
        if(!$httpResposeCode){
            $httpResposeCode = 200;
        }

        return response()->json($dataToReturn, $httpResposeCode);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $objBuilder         = new StoreBuilder();
        $dataToReturn       = $objBuilder->store($request);

        $httpResposeCode = $objBuilder->getHttpResponseCode();
        if(!$httpResposeCode){
            $httpResposeCode = 200;
        }

        return response()->json($dataToReturn, $httpResposeCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $objBuilder         = new StoreBuilder();
        $dataToReturn       = $objBuilder->show($id);

        $httpResposeCode = $objBuilder->getHttpResponseCode();
        if(!$httpResposeCode){
            $httpResposeCode = 200;
        }

        return response()->json($dataToReturn, $httpResposeCode);
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

    public function add_boock(Request $request, string $store_id, string $book_id)
    {
        $dataToReturn = [
            'data'      => [],
            'status'    => false
        ];
        
        try {

            \DB::beginTransaction();
     
            $data = $request->all();
            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->add_boock($store_id, $book_id, $data);


            \DB::commit();

            $dataToReturn['data']   = 'Store removed successfully';
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
}
