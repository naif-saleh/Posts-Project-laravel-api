<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //All Categories
    public function index()
    {
        //Get Categories Paginated
        $categories = Category::with('user', 'posts')->paginate(10);
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'All Categories',
            'categories' => $categories,
            'code' => 200,
        ]);
    }

    //Create Category
    public function createCategory(Request $request)
    {
        //Validate Request Data
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:255',
        ]);

        //Check Validated Date
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        //Create Category
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ]);
        //Generate Slug
        $category->CategorySulg();
        //Save Category
        $category->save();
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Category Created Successfully',
            'category' => $category,
            'code' => 201,
        ]);
    }


    //Single Category
    public function showCategory($id)
    {
        //Get Category
        $category = Category::with('user', 'posts')->find($id);
        //Check if Category is exists
        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found',
                'code' => 404,
            ]);
        }
        $posts = $category->posts()->with('user')->count();

        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Category Found',
            'category' => $category,
            'posts_count' => $posts,
            'code' => 200,
        ]);
    }

    //Update Category
    public function updateCategory(Request $request, $id)
    {
        //Get Category
        $category = Category::find($id);
        //Check if Category is exists
        if(!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found',
                'code' => 404,
            ]);
        }
        //Validate Request Data
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:255',
        ]);

        //Check Validated Date
        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
                'code' => 422,
            ]);
        }
        //Update Category
        $category->name = $request->name;
        $category->description = $request->description;
        $category->user_id = auth()->user()->id;
        //Generate Slug
        $category->CategorySulg();
        //Save Category
        $category->save();
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Category Updated Successfully',
            'category' => $category,
            'code' => 200,
        ]);
    }

    //Delete Category
    public function deleteCategory($id)
    {
        //Get Category
        $category = Category::find($id);
        //Check if Category is exists
        if(!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Found',
                'code' => 404,
            ]);
        }
        //Delete Category
        $category->delete();
        //Return Response
        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully',
            'category' => $category,
            'code' => 200,
        ]);
    }


    //Search Category
    public function searchCategory(Request $request)
    {
        return response()->json([
            'status' => true
        ]);
    }


}
