<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\LikeReplyController;
use App\Http\Controllers\AnoncommentController;
use App\Http\Controllers\LikeCommentController;
use App\Http\Controllers\AnonlikepostController;
use App\Http\Controllers\AuthCounselorController;
use App\Http\Controllers\CounselorreplyController;
use App\Http\Controllers\CounselorSearchController;
use App\Http\Controllers\CounselorcommentController;
use App\Http\Controllers\CounselorlikepostController;
use App\Http\Controllers\CounselorLikeReplyController;
use App\Http\Controllers\CounselorManagementController;
use App\Http\Controllers\CounselorLikeCommentController;

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



// ANONYMOUS USERS

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/password-reset-request', [AuthController::class, 'passwordResetRequest']);
Route::post('/password-recovery-answer', [AuthController::class, 'passwordRecoveryAnswer']);
Route::post('/reset-password', [AuthController::class, 'passwordReset']);

// Private Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/delete-account/{id}', [AuthController::class, 'deleteAccount']);
    Route::post('/create-post', [PostController::class, 'createPost']);

    // POST
    Route::get('/single-post/{id}', [PostController::class, 'singlePost']);
    Route::get('/all-posts-home', [PostController::class, 'allPostsHome']);
    Route::get('/all-posts-explore', [PostController::class, 'allPostsExplore']);
    Route::delete('/delete-post/{id}', [PostController::class, 'deletePost']);

    // COMMENT
    Route::post('/comment-anonymous/{id}', [AnoncommentController::class, 'anonComment']);
    Route::delete('/delete-comment-anon/{id}', [AnoncommentController::class, 'deleteComment']);
    Route::get('/all-post-comments/{id}', [AnoncommentController::class, 'allPostComments']);

    // LIKE ROUTES
    Route::post('/like-post-anon/{id}', [AnonlikepostController::class, 'likePost']);
    Route::post('/like-comment-anon/{pid}/{cid}', [LikeCommentController::class, 'likeComment']);
    Route::post('/like-reply-anon/{pid}/{cid}/{rid}', [LikeReplyController::class, 'likeReply']);
    Route::get('/all-post-likes/{id}', [LikeReplyController::class, 'allPostLikes']);
    Route::get('/all-comment-likes/{id}', [LikeReplyController::class, 'allCommentLikes']);
    Route::get('/all-reply-likes/{id}', [LikeReplyController::class, 'allReplyLikes']);

    // REPLY ROUTES
    Route::post('/reply/{id}', [ReplyController::class, 'reply']);
    Route::get('/all-comment-replies/{id}', [ReplyController::class, 'allCommentReplies']);
    Route::delete('/delete-reply-anon/{id}', [ReplyController::class, 'deleteReply']);

    //SEARCH COUNSELOR ROUTES
    Route::get('/search-counselor-username', [CounselorSearchController::class, 'searchUsername']);
    Route::get('/search-counselor-field', [CounselorSearchController::class, 'searchField']);

    // MANAGE COUNSELOR ROUTES
    Route::get('/get-single-counselor/{id}', [CounselorManagementController::class, 'singleCounselor']);
    Route::get('/counselors-by-field/{field}', [CounselorManagementController::class, 'counselorsByField']);
    Route::get('/all-counselors', [CounselorManagementController::class, 'allCounselors']);


});






// COUNSELLORS

// Public Routes
Route::post('/register-counselor', [AuthCounselorController::class, 'registerCounselor']);
Route::post('/login-counselor', [AuthCounselorController::class, 'loginCounselor']);
Route::post('/counselor-password-reset-request', [AuthCounselorController::class, 'counselorPasswordResetRequest']);
Route::post('/counselor-password-recovery-answer', [AuthCounselorController::class, 'counselorPasswordRecoveryAnswer']);
Route::post('/counselor-reset-password', [AuthCounselorController::class, 'counselorPasswordReset']);

// Private Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout-counselor', [AuthCounselorController::class, 'logoutCounselor']);

    // COMMENT
    Route::post('/comment-counselor/{id}', [CounselorcommentController::class, 'counselorComment']);
    Route::delete('/delete-comment-counselor/{id}', [CounselorcommentController::class, 'deleteComment']);
    Route::get('/all-post-comments-counselor/{id}', [CounselorcommentController::class, 'allPostComments']);

    // LIKE ROUTES
    Route::post('/like-post-counselor/{id}', [CounselorlikepostController::class, 'likePost']);
    Route::post('/like-comment-counselor/{pid}/{cid}', [CounselorLikeCommentController::class, 'likeComment']);
    Route::post('/like-reply-counselor/{pid}/{cid}/{rid}', [CounselorLikeReplyController::class, 'likeReply']);
    Route::get('/all-post-likes-counselor/{id}', [CounselorLikeReplyController::class, 'allPostLikes']);
    Route::get('/all-comment-likes-counselor/{id}', [CounselorLikeReplyController::class, 'allCommentLikes']);
    Route::get('/all-reply-likes-counselor/{id}', [CounselorLikeReplyController::class, 'allReplyLikes']);

    // REPLY ROUTES
    Route::post('/reply-counselor/{id}', [CounselorreplyController::class, 'reply']);
    Route::get('/all-comment-replies-counselor/{id}', [CounselorreplyController::class, 'allCommentReplies']);
    Route::delete('/delete-reply-counselor/{id}', [CounselorreplyController::class, 'deleteReply']);

    // MANAGE COUNSELOR ROUTES
    Route::delete('/delete-counselor-account/{id}', [CounselorManagementController::class, 'deleteAccount']);

});
