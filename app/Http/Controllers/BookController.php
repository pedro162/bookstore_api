<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use App\Domain\BookDomain;
use App\Exceptions\BookException;
use App\Http\Controllers\Controller;



class BookController extends Controller
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
            'data'  =>  [],
            'state' =>  false
        ];
        
        $stCod = 200;

        try {

            \DB::beginTransaction();
            
            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->index();

            \DB::commit();
            //print_r($response);
            //die();
            if((!$response) || !(count($response) > 0)){
                $stCod = 404;
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, $stCod);

        } catch (BookException $e) {

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
    public function store(Request $request, $id)
    {
        $dataToReturn = [
            'data'      => [],
            'status'    => false
        ];

        try {

            \DB::beginTransaction();

            $dados = $request->all();            
            
            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->create($dados);

            \DB::commit();


            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 200);

        } catch (BookException $e) {

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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataToReturn = [
            'data'  =>  [],
            'status'=>  false
        ];

        $stCod = 200;

        try {

            \DB::beginTransaction();

            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->show($id);

            \DB::commit();


            if(!$response){
                $stCod = 404;
            }

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, $stCod);

        } catch (BookException $e) {

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
            'data'      =>  [],
            'status'    =>  false
        ];

        try {

            \DB::beginTransaction();


            $dados = $request->all();            
            
            $storeDomainObj = new BookDomain();
            $response = $storeDomainObj->update($id, $dados);


            \DB::commit();

            $dataToReturn['data']   = $response;
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 200);

        } catch (BookException $e) {

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
            'data'  =>  [],
            'status'=>  false
        ];
        
        try {

            \DB::beginTransaction();


            $dados = $request->all();            
            
            $storeDomainObj = new BookDomain();
            $response       = $storeDomainObj->destroy($id);


            \DB::commit();

            $dataToReturn['data']   = 'Book removed successfully';
            $dataToReturn['state']  = true;

            return response()->json($dataToReturn, 204);

        } catch (BookException $e) {

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
