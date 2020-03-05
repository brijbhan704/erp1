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
//Route::get('requestNotification', 'PurchaseController@sendNotification');
//Route::get('potNotification', 'PurchaseController@potNotification');
Route::get('test', function () {
    event(new App\Events\StatusLiked('Someone'));
    return "Event has been sent!";
});

Route::get('/view-product/{ID}', 'InventoryController@view_supplyer');
Route::get('/updateproduct','InventoryController@updateproduct');
Route::get('showdetails','InventoryController@showdetails');
Route::get('/show/{id}/showpodetails','InventoryController@showpodetails');

Route::get('myprofile','ProfileController@edit');
Route::get('pdfview',array('as'=>'pdfview','uses'=>'RoleController@pdfview'));
Route::get('export', 'RoleController@export')->name('export');
Route::get('export/notification', 'NotificationController@export')->name('export/notification');
Route::get('export/category', 'CategoryController@export')->name('export/category');
Route::get('export/inventory', 'InventoryController@export')->name('export/inventory');
Route::get('export/pendingexpense', 'ExpenseController@export')->name('export/pendingexpense');
Route::get('export/approvedexpense', 'ExpenseController@ApprovedExpenseexport')->name('export/approvedexpense');
Route::get('export/rejectexpense', 'ExpenseController@RejectExpenseexport')->name('export/rejectexpense');
//Route::get('/pdfview','RoleController@pdfview');
//users
Route::get('pdfviewusers',array('as'=>'pdfviewusers','uses'=>'UserController@pdfview'));
Route::get('pdfviewnotification',array('as'=>'pdfviewnotification','uses'=>'NotificationController@pdfview'));
Route::get('pdfviewcategory',array('as'=>'pdfviewcategory','uses'=>'CategoryController@pdfview'));
Route::get('pdfviewinventory',array('as'=>'pdfviewinventory','uses'=>'InventoryController@pdfview'));
Route::get('pdfviewPending',array('as'=>'pdfviewPending','uses'=>'ExpenseController@pdfview'));
Route::get('pdfviewApproved',array('as'=>'pdfviewApproved','uses'=>'ExpenseController@pdfviewApproved'));
Route::get('pdfviewReject',array('as'=>'pdfviewReject','uses'=>'ExpenseController@pdfviewReject'));
Route::get('pdfviewPOorder',array('as'=>'pdfviewPOorder','uses'=>'AddproductController@pdfview'));
//Route::get('usersexport', 'UserController@export')->name('usersexport');


/*Route::get('/purchse','PurchaseController@index');
Route::get('/makepurchseOrders','PurchaseController@create');*/
Route::get('/search','ExpenseController@searchRejectAjax');
Route::get('/searchApproved','ExpenseController@searchApprovedAjax');
Route::get('/expenses/{expenseId}/expensereject', 'ExpenseController@expensereject');
Route::get('/expenses/{expenseId}/expenseapproved', 'ExpenseController@expenseapproved');
Route::post('/expenses/getNotification', 'ExpenseController@getNotification');
Route::post('/expenses/sendNotification', 'ExpenseController@sendNotification');
Route::post('/messages/getMessageById', 'MessageController@getMessageById');
Route::get('/rejectexpenses', 'ExpenseController@RejectExpenses');
Route::get('/approvedexpenses', 'ExpenseController@ApprovedExpenses');
Route::get('/rejectexpenses/{expenseId}/RejectExpenseshow', 'ExpenseController@RejectExpenseshow');
Route::get('/approveexpense/{expenseId}/ApprovedExpenseshow', 'ExpenseController@ApprovedExpenseshow');

Route::post('/getSubcategoryById', 'PurchaseController@getSubcategoryById');
/*Route::post('/sendOrderNotification', 'PurchaseController@sendNotification');*/

    
    Route::get('/logout', 'UserController@logout');
    Route::get('/users/changepass', 'UserController@changepass');
    Route::post('/users/changepass', 'UserController@changepass');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/users', 'UserController@index');
    Route::get('/notifications','NotificationController@index');
    Route::get('profile','ProfileController@edit');
     Route::get('newregister','ProfileController@register');
   
    Route::get('password','ProfileController@password');

     Route::get('users/edit', 'UserController@edit');
    Route::get('users/distroy', 'UserController@distroy');
     Route::get('users/create', 'UserController@create');
    Route::get('profile/update','ProfileController@update');
     Route::get('password','ProfileController@password');

    Route::group(['middleware' =>'auth'], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');
    Route::resource('addproduct','AddproductController');
    Route::resource('requestproduct','PurchaseController');
    Route::get('/', 'PagesController@index');
   
    Route::resource('category','CategoryController');
    Route::resource('expenses','ExpenseController');
    Route::resource('inventory','InventoryController');
   
   
    Route::resource('notifications','NotificationController');
    Route::get('/subcategorylist/{parent_id}', 'InventoryController@subcategorylist');

   
});

    
/*Route::group(['middleware' => 'App\Http\Middleware\AuthMiddleware'], function () {
    
    Route::get('/users', 'UserController@index');
    Route::post('/userIndexAjax', 'UserController@userIndexAjax');
        
    Route::get('/', 'HomeController@index')->name('home');  
    
    Route::get('/expenses', 'ExpenseController@index');  
    Route::post('/expenses/expensesIndexAjax', 'ExpenseController@expensesIndexAjax');
    Route::get('/expenses/view/{id}', 'ExpenseController@view');
    Route::post('/expenses/update/{id}', 'ExpenseController@update');
    Route::get('/expenses/category', 'ExpenseController@category');
    Route::get('/expenses/editCategory', 'ExpenseController@editCategory');
    Route::post('/expenses/getExpensesDepartmentwise', 'ExpenseController@getExpensesDepartmentwise');*/
    
    /* users routing */
   
    /*Route::get('/users/add','UserController@addUser');
    Route::post('/users/create', 'UserController@create');
    Route::get('/users/edit/{id}', 'UserController@edit');
     Route::post('/users/update/{id}', 'UserController@update');
    Route::get('/users/changepass', 'UserController@changepass');
    Route::post('/users/change_password', 'UserController@change_password');
    Route::get('/users/deleteUser/{id}', 'UserController@deleteUser');
    Route::post('/users/getUsersByDepartment', 'UserController@getUsersByDepartment');
    
    Route::get('/users/settings/{id}', 'UserController@settings');
    Route::post('/users/settings/{id}', 'UserController@settings');*/


    


    /* Route::get('/events', 'EventController@index');
    Route::post('/events/eventIndexAjax', 'EventController@eventIndexAjax'); */

//});

//Route::get('/', 'PagesController@index');

// Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function(){
//     Route::match(['get', 'post'], '/adminOnlyPage/', 'HomeController@admin');
// });

Auth::routes();

/* error routing */
Route::get('/error', 'UserController@error');
