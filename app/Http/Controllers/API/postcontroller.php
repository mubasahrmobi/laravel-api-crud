<?php

namespace App\Http\Controllers\API;


use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\basecontroller as basecontroller;

class postcontroller extends basecontroller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data['posts'] = post::all();
    return $this->sendresponse($data,' All posts Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validuser = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'discription' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,gif',
        ]
    );

    if ($validuser->fails()) {
        
        return $this->senderror('Validation error',$validuser->errors()->all());
    }

    try {
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imagename = time() . '.' . $ext;
        $img->move(public_path() . '/uploads', $imagename);

        $post = post::create([
            'title' => $request->title,
            'discription' => $request->discription,
            'image' => $imagename,
        ]);

        return $this->sendresponse($post,'Post created successfully');
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error uploading image',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $data['post'] = post::select(
        'id',
        'title',
        'discription',
        'image',
       )->where(['id'=> $id])->get();

    return $this->sendresponse($data,'Your single post');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $post = post::find($id);
    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found',
        ], 404);
    }

    $validator = Validator::make(
        $request->all(),
        [
            'title' => 'required',
            'discription' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
        ]
    );

    if ($validator->fails()) {
        return $this->senderror('Validation error',$validuser->errors()->all());
    }

    if ($request->image != '') {
        $path = public_path() . '/uploads';
        if ($post->image != '' && $post->image != null) {
            $oldFile = $path . $post->image;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move($path, $imageName);
    } else {
        $imageName = $post->image;
    }

    $post->update([
        'title' => $request->title,
        'discription' => $request->discription,
        'image' => $imageName,
    ]);

    return $this->sendresponse($post,'Post updated successfully');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $post = post::find($id);
    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found',
        ], 404);
    }

    $imagePath = public_path() . '/uploads/' . $post->image;
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $post->delete();
    
    return $this->sendresponse($post,'Post deleted successfully');
}
}

