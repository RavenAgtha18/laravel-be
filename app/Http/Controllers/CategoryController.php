<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories->count() >0) {
            return response()->json([
                'status' => true,
                'data' => $categories

            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'messege' => 'Data categories not found.'

            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = false;
        $message ='';

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:225',
            'description' => 'nullable|max:1000',

        ]);

        if ($validator->fails()) {
            $status = false;
            $message =$validator->errors();
            return response()->json([   
                'status' => $status,
                'message' => $message
            ], 400);
            
            
            }else{
                $status = true;
                $message = 'Data has been successfully added.';

                $category = new Category();
                $category->name = $request->name;
                $category->description = $request->description;
                $category->save();
                return response()->json([   
                    'status' => $status,
                    'message' => $message
                ], 200);
            }


    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if ($category != null){
            return response()->json([   
                'status' => true,
                'data' => $category
            ], 200); 
        }else{
            return response()->json([
                'status' => false,
                'messege' => 'Data categories not found.'

            ], 404);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required','max:225'],
            'description' => ['nullable','max:1000'],

        ]);

        if ($validator->fails()) {

            return response()->json([   
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }else{
            $category = Category::find($id);

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Category data has been successfully updated'
            ], 200);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::destroy($id);

        if ($category) {
            return response()->json([
                'status' => true,
                'messege' => 'The category data has been successfully deleted'

            ], 200);
        }else{
            return response()->json([
                'status' => False,
                'messege' => 'The category data deletion failed.'

            ], 404);
        }


    }
}
