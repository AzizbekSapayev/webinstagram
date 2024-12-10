<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:400000000', // Accept images and videos
        ]);

        // Store the uploaded file
        $path = $request->file('media')->store('media', 'public');

        // Create the story record
        $story = Story::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'media_path' => $path,
        ]);
       
        return redirect('savestory')->with('success', 'Story saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
{
    $story = Story::find($id);

    if (!$story) {
        return response()->json(['error' => 'Story not found.'], 404);
    }

    // Delete the story
    $story->delete();

    return response()->json(['message' => 'Story deleted successfully.'], 200);
}

}
