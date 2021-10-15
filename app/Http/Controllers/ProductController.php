<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //get all products
    public function index(){
        $data=Product::all();
        return response()->json([
            'data'=>$data
        ]);
    }

    //add product
    public function addproduct(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required | max:20',
            'description'=>'required  | max:200',
            'image'=>'required | image | mimes:jpeg,jpg,png',
            'category'=>'required'
        ]);
        
        if($validator->fails()){
            return response()->json([
                 'message'=>$validator->messages()
            ]);
        }
        else{
            $data=New Product;
            $data->title=$request->title;
            $data->description=$request->description;
            $data->category_id=$request->category;
            $data->user_id=1;


            if($request->hasFile('image')){
                $destination='public/images/';
                $name=time().'.'.$request->file('image')->extension();
                $request->file('image')->storeAs(
                    $destination,$name
                );
                $data->image=$name;
            }

            $save=$data->save();
            if($save){
                return response()->json([
                    'message'=>'success'
                ],200);
            }
            else{
                return response()->json([
                    'message'=>'failure'
                ],500);
            }
        }
    }

    //edit product
    public function editproduct($id){
        $data=Product::find($id);
        return response()->json([
            'data'=>$data
        ]);
    }

    //update product
    public function updateproduct(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required | max:20',
            'description'=>'required  | max:200',
            'category'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()
            ]);
        }
        else{
            $data=Product::find($request->id);
            $data->title=$request->title;
            $data->description=$request->description;
            $data->category_id=$request->category;
            if($request->hasFile('image')){
                $validator=Validator::make($request->all(),[
                    'image'=>'required | image | mimes:jpeg,jpg | max:1000'
                ]);
                if($validator->fails()){
                    return response()->json([
                        'message'=>$validator->messages()
                    ]);
                }
                else{
                    $destination='./storage/images/'.$data->thumbnail;
                    if(File::exists($destination)){
                        File::delete($destination);
                    }
                    $newdestination='./public/images/';
                    $name=time().'.'.$request->file('image')->extension();
                    $request->file('image')->storeAs($newdestination,$name);
                    $data->image=$name;
                }
            }
            $updatedata=$data->save();
            if($updatedata){
                return response()->json([
                    'message'=>'success'
                ]);
            }
            else{
                return response()->json([
                    'message'=>'failure'
                ]);
            }



        }
    }

    //delete product
    public function deleteproduct($id){
        $data=Product::find($id);
        $imagedestination='./storage/images/'.$data->image;

        if(File::exists($imagedestination)){
            File::delete($imagedestination);
            $postdelete=$data->delete();
            if($postdelete){
                return response()->json([
                    'message'=>'success'
                ],200);
            }
            else{
                return response()->json([
                    'message'=>'Something went wrong'
                ],500);
            }
        }
        else{
            return response()->json([
                'message'=>'Something  went wrong'
            ],500);
        }
    }
}
