<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\SuccessResource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest('id')->get();

        return new SuccessResource([
            'message' => 'All posts!',
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $formData = $request->validated();

        $validation['slug'] = Str::slug($formData['title']);

        //photo will upload if exixts
        if(array_key_exists('photo',$formData)){
            $formData['photo'] = Storage::putFile('',$formData['photo']);
        }

        //create post
        Post::create($formData);
        return (new SuccessResource(['message' => 'Successfully post created!']))->response()->setStatusCode(201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new SuccessResource([
            'data' => $post,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $formData = $request->validated();

        $formData['slug'] = Str::slug($formData['title']);

        //photo will upload if exixts
        if(array_key_exists('photo',$formData)){
            Storage::delete($post->photo);
            $formData['photo'] = Storage::putFile('',$formData['photo']);
        }

        //create post
        $post->update($formData);
        return (new SuccessResource(['message' => 'Successfully post updated!']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::delete($post->photo);
        $post->delete();

        return (new SuccessResource(['message' => 'Successfully post deleted!']));
    }
}
