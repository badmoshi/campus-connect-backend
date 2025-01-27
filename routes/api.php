<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Notifications\NotificationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::prefix('/user')->group(function () {

        Route::get('/{user}', [UserProfileController::class, 'show']);
        Route::get('/{user_id}/posts', [PostController::class, 'userPost']);
        Route::post('/{user}', [UserProfileController::class, 'updateUserProfile']);
        
        Route::get('/{user}/notification', [NotificationsController::class, 'getLatestNotifications']);
        Route::get('/{user}/notification/read-all', [NotificationsController::class, 'markAllNotificationRead']);
        Route::get('/{user}/notification/{notification}/read', [NotificationsController::class, 'markNotificationRead']);
        
        Route::put('/following/{user}', [FollowerController::class, 'follow']);
        Route::delete('/following/{user}', [FollowerController::class, 'unfollow']);
        Route::get('/followers/{user}', [FollowerController::class, 'followers']);
        Route::get('/following/{user}', [FollowerController::class, 'following']);
        Route::get('/isfollowing/{user}', [FollowerController::class, 'isFollowed']);
        
    }); 
    
    Route::post('posts/{post}/reaction', [PostController::class, 'postReaction']);
    Route::post('comments/{comment}/reaction', [PostCommentController::class, 'commentReaction']);
    Route::post('/upload', [UserProfileController::class, 'uploadSingleFile']);

    Route::apiResources([
        'posts' => PostController::class,
        'posts/{post}/comment' => PostCommentController::class
    ]);
});

 