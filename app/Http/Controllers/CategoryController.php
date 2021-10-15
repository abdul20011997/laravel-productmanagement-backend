<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //get all category
    public function index(){
        $data=Category::all();
        return response()->json(['data'=>$data],200);
    }

    //add category
    public function addcategory(Request $request){
        
        $validator=Validator::make($request->all(),[
            'title'=>'required | max:20',
        ]);
        
        if($validator->fails()){
            return response()->json([
                 'message'=>$validator->messages()
            ]);
        }
        else{
            $data=New Category;
            $data->title=$request->title;
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

    //edit category
    public function editcategory($id){
        $data=Category::find($id);
        return response()->json(['data'=>$data]);
    }

    //update category
    public function updatecategory(Request $request){
        
        $validator=Validator::make($request->all(),[
            'title'=>'required | max:20',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->messages()
            ]);
        }
        else{
        $data=Category::find($request->id);
        $data->title=$request->title;
        $updatedata=$data->save();
        if($updatedata){
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

    //delete category
    public function deletecategory($id){
        $category=Category::find($id);
        $deletecategory=$category->delete();
        if($deletecategory){
            return response()->json([
                'message'=>'success'
            ]);
        }
        else{
            return response()->json([
                'message'=>'error'
            ]);
        }
    }
}
