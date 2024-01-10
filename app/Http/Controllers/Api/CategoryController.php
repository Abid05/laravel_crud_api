<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return new SuccessResource([
            'message' => 'All category!',
            'data' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        
        $formData = $request->validated();
        $formData['slug'] = Str::slug($formData['name']);

        Category::create($formData);

        return (new SuccessResource(['message' => 'Successfully category created!']))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return new SuccessResource([
            'data' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,'.$category->id,
        ]);
        
        if ($validation->fails()) {

            return (new ErrorResource($validation->getMessageBag()))->response()->setStatusCode(422);
        }

        $formData = $validation->validated();
        $formData['slug'] = Str::slug($formData['name']);

        $category->update($formData);

        return (new SuccessResource(['message' => 'Successfully category updated!']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();

        return (new SuccessResource(['message' => 'Successfully category deleted!']));
    }
}
