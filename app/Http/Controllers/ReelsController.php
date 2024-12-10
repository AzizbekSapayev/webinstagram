<?php

// app/Http/Controllers/ReelsController.php

namespace App\Http\Controllers;

use App\Models\Story; // Or your respective model for stories/media
use Illuminate\Http\Request;

class ReelsController extends Controller
{
    public function index()
    {
        // Fetch the stories or videos you want to display on the Reels page
        $stories = Story::where('media_path', 'like', '%.mp4')->get();

        return view('reels', compact('stories'));
    }
}

