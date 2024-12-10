<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $follower = auth()->user(); // Authenticated user
        $current = DB::table("users")->where('id', $id)->first(); // User being followed
    
        if (!$current || !$follower) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Check if already following
        $check = DB::table("followers")
            ->where('current_user', $current->id)
            ->where('follower', $follower->id)
            ->exists();
    
        if ($check) {
            DB::table("followers")
            ->where('current_user', $current->id)
            ->where('follower', $follower->id)
            ->delete();

            DB::table("followings")
            ->where('current_user',$follower->id )
            ->where('followedperson', $current->id)
            ->delete();

            return redirect()->back()->with('success', 'You have unfollowed ' . $current->name . '.');
        }
    
        // Insert follow relationship
        DB::table("followers")->insert([
            'current_user' => $current->id,
            'follower' => $follower->id,
        ]);

        DB::table("followings")->insert([
            'current_user' => $follower->id,
            'followedperson' => $current->id,
        ]);

        
    
       // return redirect()->back()->with('success', 'You are now following ' . $current->name . '!');
        return redirect('/');
    }

    public function unfollow($userId)
    {
        $currentUser = auth()->user();
        
        // Remove the follow relationship
        DB::table('followers')
          ->where('follower', $currentUser->id)
          ->where('current_user', $userId)
          ->delete();

        return redirect()->back();
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
        //
    }
}
