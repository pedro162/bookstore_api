<?php 

namespace App\Builder;

use Illuminate\Http\Request;
use App\Domain\BookDomain;
use App\Exceptions\BookException;
use App\Http\Controllers\Controller;

class BookBuilder extends Builder{
	
	/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataToReturn = [
            'data'  =>  [],
            'state' =>  false
        ];
        
        $stCod = 200;

        try {

            \DB::beginTransaction();
            
            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->index();

            \DB::commit();

            if((!$response) || !(count($response) > 0)){
                $stCod 		= 404;
                $response 	= [];
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;


        } catch (BookException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;
            
            $stCod = 500;
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
            'data'      => [],
            'state'    => false
        ];

        $stCod = 500;

        try {

            \DB::beginTransaction();

            $data = $request->all();            
            
            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->create($data);

            \DB::commit();


            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            $stCod = 200;

        } catch (BookException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            //$msg  = $e->getMessage().' - '.$e->getLine().' - '.$e->getFile();
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 500;
            
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
            'data'  =>  [],
            'state'=>  false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->show($id);

            \DB::commit();

            if((!$response) || !(count($response) > 0)){
                $stCod 		= 404;
                $response 	= [];
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

        } catch (BookException $e) {

            \DB::rollback();

            $msg  = $e->getMessage();
            
            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 400;

        }catch (\Exception $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 500;

        }catch (\Error $e) {

            \DB::rollback();

            $msg  = $e->getMessage();

            $dataToReturn['data']   = $msg;
            $dataToReturn['state']  = false;

            $stCod = 500;
            
        }

        $this->setHttpResponseCode($stCod);

        return $dataToReturn;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataToReturn = [
            'data'      =>  [],
            'state'    =>  false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $data = $request->all();            
            
            $storeDomainObj = new BookDomain();
            $response       = $storeDomainObj->update($id, $data);

            \DB::commit();

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

        } catch (BookException $e) {

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataToReturn = [
            'data'  =>  [],
            'state'=>  false
        ];
        
        $stCod = 200;

        try {

            \DB::beginTransaction();
            
            $storeDomainObj = new BookDomain();
            $response       = $storeDomainObj->destroy($id);


            \DB::commit();

            $dataToReturn['data']   = 'Book removed successfully';
            $dataToReturn['state']  = true;

        } catch (BookException $e) {

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
