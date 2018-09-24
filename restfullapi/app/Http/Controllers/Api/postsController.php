<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class postsController extends Controller
{
    use ApiResponseTrait;
    public  function index(){

   //     $offset=request()->has('offset') ? request()->get('offset') :0 ;
        $posts= PostResource::collection(Post::paginate($this->paginateNumber));
        return  $this->apiResponse($posts);
    }

    public function show($id){
        $post= Post::find($id);
        if($post){
            return  $this->returnSucessPost($post);

        }else{
          return $this->notFoundResponse();

        }
    }

    public function delete($id){
        $post= Post::find($id);
        if($post){

            $post->delete();
            return  $this->deleteResponse();

        }else{
            return $this->notFoundResponse();

        }
    }

    public  function  store(Request $request){
   /*     if (!$request->has('title') && $request->get('title') == ''){
            return $this->apiResponse(null,'title is required',422);
        }

        if (!$request->has('body') && $request->get('body') == ''){
            return $this->apiResponse(null,'body is required',422);
        }
*/

   $validation=$this->validation($request);

   if($validation instanceof  Response){
       return $validation;
   }

    $post= Post::create($request->all());

        if($post){
           return $this->createdResponse(new PostResource($post));

        }else{
            $this->unknownError();

        }

    }

    public  function update($id,Request $request){
        /*     if (!$request->has('title') && $request->get('title') == ''){
                 return $this->apiResponse(null,'title is required',422);
             }

             if (!$request->has('body') && $request->get('body') == ''){
                 return $this->apiResponse(null,'body is required',422);
             }
     */
        $validation=$this->validation($request);

        if($validation instanceof  Response){
            return $validation;
        }

        $post= Post::find($id);
        if(!$post){
            return $this->notFoundResponse();

        }
      $post->update($request->all());

        if($post){
         return  $this->returnSucessPost($post);

        }else{
            $this->unknownError();

        }
    }

    public function validation($request){
       return $this->apiValidation($request,[
           'title' => 'required|min:3|max:191',
           'body' => 'required|min:10'
       ]);
    }

    public  function  returnSucessPost($post){
        return $this->apiResponse(new PostResource($post));
    }



}




