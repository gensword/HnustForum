<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    return view('test');
});

#-------------------------------------------Show page----------------------------------------

Route::get('/index', 'IndexController@index');
Route::get('/index/{category_id}', 'IndexController@index')->name('category');
Route::get('/auth/register', 'IndexController@showRegisterPage');
Route::get('/auth/login', 'IndexController@showLoginPage');
Route::get('/users/{user_id}', 'IndexController@showUserDetail');
Route::get('/users/{user_id}/edit', 'UserController@showEdit');
Route::get('/users/{user_id}/edit/edit_pwd', 'UserController@showEditPwd');
Route::get('/users/{user_id}/edit/edit_avatar', 'UserController@showEditAvatar');
Route::get('/users/{user_id}/edit/edit_notify', 'UserController@showEditNotify');
Route::get('/articles/{article_id}', 'ArticleController@showArticle');
Route::get('/articles/create/{category_id}', 'ArticleController@showCreatePage')->middleware('auth');
Route::get('/users/{user_id}/messages', 'MessageController@showMessages');
Route::get('/users/{user_id}/notify', 'UserController@showNotify');
Route::get('/users/{user_id}/messages/{message_id}', 'MessageController@showTalks');
Route::get('/users/message/to/{toUid}', 'MessageController@showMessageTo')->middleware('auth');
Route::get('/showImages/{gender}', 'HiManController@showImages');
Route::get('/users/uploadImg/{gender}', 'HiManController@showUploadPage')->middleware('auth');

#----------------------------------Authentication-------------------------------------

Auth::routes();
Route::get('/logout', 'UserController@logout');


#-----------------------------------Article Stuff--------------------------------------

Route::get('/article/readIncrement', 'ArticleController@readTotalIncrement');
Route::post('/article/votesCount', 'ArticleController@postVotes');
Route::post('/article/{article_id}/postComments', 'ArticleController@postComments');
Route::post('/article/commentVote', 'ArticleController@postCommentsVote');
Route::post('/article/postImg', 'ArticleController@postArticleImg');
Route::post('/article/post/{category_id}', 'ArticleController@postArticle');
Route::get('/article/search', 'ArticleController@searchArticles');


#------------------------------------User Stuff------------------------------------------

Route::post('/users/{user_id}/postInfo', 'UserController@postInfo');
Route::post('/users/{user_id}/postPassword', 'UserController@postPassword');
Route::get('/users/{user_id}/vote', 'UserController@showVoteArticle');
Route::get('/users/{user_id}/publish', 'UserController@showPublishArticle');
Route::get('/users/{user_id}/comment', 'UserController@showCommentArticle');
Route::get('/users/{user_id}/follow', 'UserController@showFollowers');
Route::post('/users/{user_id}/postAvatar', 'UserController@postAvatar');
Route::post('/users/setNotifyStatus', 'UserController@notifyStatus');
Route::post('/users/getNotifyStatus', 'UserController@getNotifyStatus');
Route::get('/users/follow/{followUid}', 'UserController@follow')->middleware('auth');
Route::get('/users/cancelFollow/{cancelUid}', 'UserController@cancelFollow')->middleware('auth');
Route::post('/users/{user_id}/postImages/{gender}', 'HiManController@postImages');



#--------------------------------Message Stuff---------------------------------------------

Route::post('/sendMessages', 'MessageController@sendMessage');


#---------------------------------News Stuff------------------------------------------------
Route::post('/getNotReadMessages', 'NewsController@getNotReadMessages');
Route::post('/getNotReadNotifications', 'NewsController@getNotReadNotifications');




Route::get('/home', 'IndexController@index');




