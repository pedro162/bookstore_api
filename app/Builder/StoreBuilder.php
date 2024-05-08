<?php 

namespace App\Builder;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Request;
use Illuminate\Http\Request;
use App\Domain\StoreDomain;
use App\Exceptions\StoreException;
use App\Builder\Builder;


class StoreBuilder extends Builder{
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
                $stCod 		= 404;
                $response 	= [];
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;


        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;
            
        }

        $this->setHttpResponseCode($stCod);

        return $dataToReturn;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataToReturn = [
            'data'  => [],
            'state'=> false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $data = $request->all();            
            
            $storeDomainObj = new StoreDomain();
            $response       = $storeDomainObj->create($data);

            \DB::commit();


            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            //$msg  = $e->getMessage().' - '.$e->getLine().' - '.$e->getFile();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;            
        }

        $this->setHttpResponseCode($stCod);

        return $dataToReturn;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataToReturn = [
            'data'  => [],
            'state'=> false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $storeDomainObj = new StoreDomain();
            $response = $storeDomainObj->show($id);

            \DB::commit();
            
            if((!$response) || !(count($response) > 0)){
                $stCod 		= 404;
                $response 	= [];
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

        } catch (StoreException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            $stCod 					= 500;
            
        }

        $this->setHttpResponseCode($stCod);

        return $dataToReturn;
    }
}
