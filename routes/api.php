<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */


//get latest sedcard images for approval
// Route::post('/getSedcards', 'Api\ApiController@getSedcard');

//get latest sedcard images for approval by user id
Route::post('/getSedcardByid', 'Api\ApiController@getSedcardByid');

//change sedcard image status
// Route::post('/changeSedcardstatus', 'Api\ApiController@changeSedcardstatus');

Route::post('/handler', 'Api\ApiController@callApiRequest');
Route::post('/createlead', 'Api\ApiController@createUserLead');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
* Migration API Start
*/
	Route::post('/migrationApiRequest', 'Account\MigrationController@migrationApiRequest');
	Route::get('/migrationApiRequest', 'Account\MigrationController@migrationApiRequest');
/*
* Migration API End
*/
/* api to clear response cache */
Route::post('/clear-response-cache', 'Api\ApiController@clearCache');

// api intregation data
	// Route::get('/blogcategory', 'MigrationController@getcategory');
	// Route::get('/blogdata', 'MigrationController@blogdata');
	// Route::get('/getSetCategoryParant', 'MigrationController@getSetCategoryParant');
	// Route::get('/blogs', 'MigrationController@getBlogs');
	// Route::get('/getmodellist', 'MigrationController@getModelsList');
	// Route::get('/getjobcategories', 'MigrationController@getJobCatgeories');
	// Route::get('/blogtags', 'MigrationController@getBlogTags');
	// Route::get('/setjobcatgeories' , 'MigrationController@setJobCatgeories');
	// Route::get('/getpackages', 'MigrationController@getPackages');
	// Route::get('/modelcategory', 'MigrationController@getModelCategories');
	// Route::get('/partnercategory', 'MigrationController@getPartnerCategories');
	// Route::get('/modeleyecolor', 'MigrationController@getModelEyeColor');
// api intregation