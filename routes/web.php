<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ChatController;
use App\Models\Story;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReelsController;
use App\Http\Controllers\StoryController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Seeder;

// Rollar yaratish
// $adminRole = Role::create(['name' => 'admin']);
// $userRole = Role::create(['name' => 'user']);

// // Ruxsatlar yaratish
// $manageUsersPermission = Permission::create(['name' => 'manage users']);
// $viewDashboardPermission = Permission::create(['name' => 'view dashboard']);

// // Ruxsatlarni rollarga biriktirish
// $adminRole->givePermissionTo(['manage users', 'view dashboard']);
// $userRole->givePermissionTo('view dashboard');

Route::get('/blockUser/{id}', function($id){
    $user = auth()->user();
    $blamed = User::find($id);
    if($user){
        if($user->hasRole('admin')){
            $blamed->assignRole('blocked');
        }else{
            return redirect('/');
        }
        return redirect('/controllusers');
    }
    return redirect('/');
});

Route::get('/unblock/{id}', function($id){
    $blocked = User::find($id);
    $blocked->removeRole('blocked');
    return redirect('/controllusers');
});

Route::get('/controllusers', function(){
    $user = auth()->user();
    if(!$user->hasRole('admin')){
        return redirect('/');
    }
    $users = User::all(); 
    return view('controlusers', compact('users'));
});

Route::delete('/stories/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');

Route::get('/blockuser/{id}', function($id){
    $user = DB::table('users')->where('id',$id)->first();

});


Route::get('/reels', [ReelsController::class, 'index'])->name('reels');


Route::match(['get', 'post'], "/savestory", [StoryController::class, "store"])->name("savestory");

Route::get('/search', function(){
    $stories = Story::with('user')->orderByDesc('id')->get();
    return view("search", compact('stories'));
});

Route::get('/', function () {
    $user = auth()->user();
    if($user){
    $users = DB::table('users')->where('id', '!=', auth()->id())->get();
    //$users = DB::table('users')->get();
    // $stories = Story::with('user')->orderByDesc('id')->get();

    $stories = Story::with('user')
    ->whereDoesntHave('user', function($query) {
        $query->whereHas('roles', function($query) {
            $query->where('name', 'blocked'); // Check if user has 'blocked' role
        });
    })
    ->orderByDesc('id')
    ->get();


    
    
    // Get the list of users the current user is following
    $followedUsers = DB::table('followers')
                        ->where('follower', $user->id)
                        ->pluck('current_user')  // IDs of users followed by the current user
                        ->toArray();
    }else{
        return redirect('/login');
    }
    return view('home', compact('users', 'stories', 'user', 'followedUsers'));
});


Route::get('/delete/{id}', function($id){
    DB::table("stories")->where('id',$id)->delete();
    return redirect('dashboard');
});

Route::get('/create-room/{id}', [ChatController::class, 'createRoom']);

//Route::get('/chatroom/{id}');

Route::post('/send-message', [ChatController::class, 'sendMessage'])->name("sendMessage");



Route::get('/messages/{chatRoomId}', [ChatController::class, 'getMessages']);



Route::get('/follow/{id}', [FollowController::class, 'store'])->name("follow");

Route::get('/unfollow/{id}', [FollowController::class, 'store'])->name("follow");

Route::get("/create", [StoryController::class, "create"])->name("create");

Route::get('/dashboard', function () {
    $user = auth()->user();
    $followingCount = DB::table("followings")->where('current_user',$user->id)->count(); 
    
    $stories = Story::where('user_id', $user->id)->get(); 
    return view('dashboard', compact('stories','user','followingCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
