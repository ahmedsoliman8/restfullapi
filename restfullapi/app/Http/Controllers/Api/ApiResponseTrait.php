<?php
namespace App\Http\Controllers\Api;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

trait  ApiResponseTrait{

  public  $paginateNumber=10;
//https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
    /*
   * [
   * 'data' =>
   *  'status' => true,false
   *  'error' =>
   * ]
   */

    public  function apiResponse($data=null,$error=null,$code=200){
      $array=[
          'data' => $data,
          'status' => in_array($code,$this->sucessCode()) ? true :false,
          'error' => $error

      ];

      return response($array,$code);
    }

    public function sucessCode(){
        return [
          200,201,202
        ];
    }

    public  function notFoundResponse(){
        return $this->apiResponse(null,'not Found !',404);
    }

    public function apiValidation($request,$array){
        $validate=Validator::make($request->all(),$array);

        if($validate->fails()){
            return $this->apiResponse(null,$validate->errors(),422);
        }
    }

    public  function unknownError(){
        return $this->apiResponse(null,'Unknown Error',520);
    }

    public  function createdResponse($data){
        return $this->apiResponse($data,null,201);

    }

    public  function deleteResponse(){
        return $this->apiResponse(true,null,200);

    }
}

