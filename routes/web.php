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

Route::get('/reglament', function()
{
    return view('reglament');
});

/*
 * Tags routes
 * */
Route::get('/tags', 'IndexController@showtags');
Route::post('/tags', 'IndexController@filtertags');


/*
 *
 * User routes
 * */
Route::get('/cabinet/{user}', 'User\HomeController@cabinet')->name('cabinet');

Route::middleware('checkuser')->group(function()
{
	Route::get('/', 'User\HomeController@index')->name('home');
	Route::get('/report', 'User\HomeController@index')->name('home');
    Route::post('/api/search', 'User\HomeController@apisearch');
    Route::get('/search/form', 'User\HomeController@advanced_search_form');
    Route::post('/search', 'User\HomeController@advanced_search');
    Route::get('/simply_search/{q}', 'User\HomeController@search');
	Route::post('/simply_search', 'User\HomeController@search');
	Route::get('/migrate', 'Migrate\MigrateController@migrate');
	Route::get('/migrate_one', 'Migrate\MigrateController@migrate_one');
	Route::get('/migrate_two', 'Migrate\MigrateController@migrate_two');
	Route::get('/delete', 'Migrate\MigrateController@delete');
    /*Bug*/
	Route::post('/bug', 'User\HomeController@bug')->name('bug');
});

Route::middleware('checkuser')->prefix('/report/{slug}')->group(function()
{
	/*Report*/
	Route::get('/', 'Report\ReportController@report_list');
	Route::get('/show/{report}', 'Report\ReportController@report_show');
	Route::get('/article/{article}', 'Report\ReportController@item_article');
});

Route::middleware('checkanalyst')->group(function()
{
	Route::get('/plannedexhibition/add2/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@create2form');
});
/*
 * Analyst routes
 *
 * */
Route::middleware('checkanalyst')->prefix('/report/{slug}')->group(function()
{
    //Route::get('/', 'Analyst\HomeController@index');

    //Route::get('/monthly', 'Analyst\MonthlyController@monthly_list')->name('monthly');
    //Route::get('/monthly/show/{monthlyreport}', 'Analyst\MonthlyController@monthly_item');
   // Route::get('/monthly/article/{monthlyarticle}', 'Analyst\MonthlyController@monthly_item_article');
    //Route::get('/monthly/add1', 'Analyst\MonthlyController@create1form');
    //Route::post('/monthly/add1', 'Analyst\MonthlyController@create1');
    //Route::get('/monthly/updreport/{monthlyreport}', 'Analyst\MonthlyController@updreportform');
    //Route::post('/monthly/updreport/{monthlyreport}', 'Analyst\MonthlyController@updreport');
    //Route::delete('/monthly/{monthlyreport}/deletereport', 'Analyst\MonthlyController@delete_montlyreport');
   // Route::get('/monthly/publish/{monthlyreport}', 'Analyst\MonthlyController@publish');
    //Route::get('/monthly/add2/{monthlyreport}', 'Analyst\MonthlyController@create2form');
   // Route::get('/monthly/add3/{category}/{subcategory}/{monthlyreport}', 'Analyst\MonthlyController@create3form');
   // Route::post('/monthly/add3/{flag?}', 'Analyst\MonthlyController@create3');//++
  //  Route::delete('/monthly/{monthlyarticle}/deletearticle', 'Analyst\MonthlyController@delete_article');
  //  Route::delete('/monthly/{monthlyreport}/{category_id}/deletecategory', 'Analyst\MonthlyController@delete_category');
 //   Route::get('/monthly/upd/{monthlyarticle}', 'Analyst\MonthlyController@upd_form');
//    Route::put('/monthly/upd/{flag?}', 'Analyst\MonthlyController@update');//++
  //  Route::put('/monthly/publish/{monthlyreport}', 'Analyst\MonthlyController@publish');
 //   Route::put('/monthly/article_publish/{monthlyarticle}', 'Analyst\MonthlyController@article_publish');
  //  Route::put('/monthly/article_for_approval/{monthlyarticle}', 'Analyst\MonthlyController@article_for_approval');

    //Route::get('/weekly', 'Analyst\WeeklyController@weekly_list')->name('weekly');
    //Route::get('/weekly/show/{weeklyreport}', 'Analyst\WeeklyController@weekly_item');
   // Route::get('/weekly/article/{weeklyarticle}', 'Analyst\WeeklyController@weekly_item_article');
    //Route::get('/weekly/add1', 'Analyst\WeeklyController@create1form');
    //Route::post('/weekly/add1', 'Analyst\WeeklyController@create1');
    //Route::get('/weekly/updreport/{weeklyreport}', 'Analyst\WeeklyController@updreportform');
    //Route::post('/weekly/updreport/{weeklyreport}', 'Analyst\WeeklyController@updreport');
    //Route::get('/weekly/updreport/{weeklyreport}', 'Analyst\WeeklyController@updreportform');
   // Route::post('/weekly/updreport', 'Analyst\WeeklyController@updreport');
    //Route::delete('/weekly/{weeklyreport}/deletereport', 'Analyst\WeeklyController@delete_weeklyreport');
    //Route::delete('/weekly/{weeklyarticle}/deletearticle', 'Analyst\WeeklyController@delete_article');
   // Route::delete('/weekly/{weeklyreport}/{category_id}/deletecategory', 'Analyst\WeeklyController@delete_category');
    //Route::put('/weekly/publish/{weeklyreport}', 'Analyst\WeeklyController@publish');
   // Route::put('/weekly/article_publish/{weeklyarticle}', 'Analyst\WeeklyController@article_publish');
  //  Route::put('/weekly/article_for_approval/{weeklyarticle}', 'Analyst\WeeklyController@article_for_approval');
    //Route::get('/weekly/add2/{weeklyreport}', 'Analyst\WeeklyController@create2form');
    //Route::get('/weekly/add3/{category}/{weeklyreport}', 'Analyst\WeeklyController@create3form');
    //Route::post('/weekly/add3/{flag?}', 'Analyst\WeeklyController@create3'); //++
    //Route::get('/weekly/upd/{weeklyarticle}', 'Analyst\WeeklyController@upd_form');
    //Route::put('/weekly/upd/{flag?}', 'Analyst\WeeklyController@update');//++

   // Route::get('/countrycatalog', 'Analyst\CountrycatalogController@yearly_list')->name('countrycatalog');
    //Route::get('/countrycatalog/show/{countrycatalog}', 'Analyst\CountrycatalogController@yearly_item');
   // Route::get('/countrycatalog/article/{infocountry}/{countrycatalog}', 'Analyst\CountrycatalogController@yearly_item_article');
   // Route::get('/countrycatalog/add1', 'Analyst\CountrycatalogController@create1form');
   // Route::post('/countrycatalog/add1', 'Analyst\CountrycatalogController@create1');
    //Route::get('/countrycatalog/updreport/{countrycatalog}', 'Analyst\CountrycatalogController@updreportform');
   // Route::post('/countrycatalog/updreport/{countrycatalog}', 'Analyst\CountrycatalogController@updreport');
  //  Route::delete('/countrycatalog/{countrycatalog}/deletereport', 'Analyst\CountrycatalogController@delete_countrycatalog');
  //  Route::get('/countrycatalog/publish/{countrycatalog}', 'Analyst\CountrycatalogController@publish');
    //Route::get('/countrycatalog/addregion/{countrycatalog}', 'Analyst\CountrycatalogController@createregionform');
    //Route::post('/countrycatalog/addregion', 'Analyst\CountrycatalogController@createregion');
   // Route::post('/countrycatalog/addregion/{flag}', 'Analyst\CountrycatalogController@createregion');
   // Route::get('/countrycatalog/add2/{countrycatalog}', 'Analyst\CountrycatalogController@create2form');
   // Route::get('/countrycatalog/add3/{region}/{countrycatalog}', 'Analyst\CountrycatalogController@create3form');
    //Route::post('/countrycatalog/add3/{flag?}', 'Analyst\CountrycatalogController@create3'); //++
  //  Route::get('/countrycatalog/upd/{infocountry}/{countrycatalog}', 'Analyst\CountrycatalogController@upd_form');
  //  Route::put('/countrycatalog/upd/{flag?}', 'Analyst\CountrycatalogController@update'); //++
  //  Route::delete('/countrycatalog/{infocountry}/deletearticle', 'Analyst\CountrycatalogController@delete_article');
 //   Route::delete('/countrycatalog/{region}/deleteregion', 'Analyst\CountrycatalogController@delete_region');
 //  Route::put('/countrycatalog/updregion/{region}/{countrycatalog}/{flag?}', 'Analyst\CountrycatalogController@update_region');//++
  //  Route::get('/countrycatalog/updregion/{region}/{countrycatalog}', 'Analyst\CountrycatalogController@upd_form_region');//++
 //   Route::put('/countrycatalog/publish/{countrycatalog}', 'Analyst\CountrycatalogController@publish');
  //  Route::put('/countrycatalog/article_publish/{infocountry}', 'Analyst\CountrycatalogController@article_publish');
  // Route::put('/countrycatalog/article_for_approval/{infocountry}', 'Analyst\CountrycatalogController@article_for_approval');

   // Route::get('/yearly', 'Analyst\YearlyController@list')->name('yearly');;
    //Route::get('/yearly/show/{yearlyreport}', 'Analyst\YearlyController@item');
   // Route::get('/yearly/article/{yearlyarticle}', 'Analyst\YearlyController@item_article');
    //Route::get('/yearly/add1', 'Analyst\YearlyController@create1form');
    //Route::post('/yearly/add1', 'Analyst\YearlyController@create1');
 //   Route::get('/yearly/updreport/{yearlyreport}', 'Analyst\YearlyController@updreportform');
 //   Route::post('/yearly/updreport/{yearlyreport}', 'Analyst\YearlyController@updreport');
 //   Route::delete('/yearly/{yearlyreport}/deletereport', 'Analyst\YearlyController@delete_report');
  //  Route::get('/yearly/publish/{yearlyreport}', 'Analyst\YearlyController@publish');
    //Route::get('/yearly/add2/{yearlyreport}', 'Analyst\YearlyController@create2form');
    //Route::post('/yearly/createcategory', 'Analyst\YearlyController@createcategory');
    //Route::post('/yearly/createsubcategory', 'Analyst\YearlyController@createsubcategory');
    //Route::get('/yearly/add3/{yearlyreport}/{yearlycategory?}/{yearlysubcategory?}/', 'Analyst\YearlyController@create3form');
  //  Route::post('/yearly/add3/{flag?}', 'Analyst\YearlyController@create3');//+
 //   Route::delete('/yearly/{yearlycategory}/deletecategory', 'Analyst\YearlyController@delete_category');
  //  Route::delete('/yearly/{yearlysubcategory}/deletesubcategory', 'Analyst\YearlyController@delete_subcategory');
	//Route::get('/yearly/upd_category/{yearlycategory}', 'Analyst\YearlyController@upd_form_category');
//	Route::get('/yearly/upd_subcategory/{yearlysubcategory}', 'Analyst\YearlyController@upd_form_subcategory');
	//Route::put('/yearly/upd_subcategory/{yearlysubcategory}/{flag?}', 'Analyst\YearlyController@update_subcategory');
	//Route::put('/yearly/upd_category/{yearlycategory}/{flag?}', 'Analyst\YearlyController@update_category');
  //  Route::delete('/yearly/{yearlyarticle}/deletearticle', 'Analyst\YearlyController@delete_article');
  //  Route::get('/yearly/upd/{yearlyarticle}', 'Analyst\YearlyController@upd_form');
  //  Route::put('/yearly/upd/{flag?}', 'Analyst\YearlyController@update');//++
  //  Route::put('/yearly/publish/{yearlyreport}', 'Analyst\YearlyController@publish');
 //   Route::put('/yearly/article_publish/{yearlyarticle}', 'Analyst\YearlyController@article_publish');
  //  Route::put('/yearly/article_for_approval/{yearlyarticle}', 'Analyst\YearlyController@article_for_approval');

    //Route::get('/plannedexhibition', 'Analyst\PlannedexhibitionController@years_list');
    //Route::get('/plannedexhibition/show/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@list');
    //Route::get('/plannedexhibition/add1', 'Analyst\PlannedexhibitionController@create1form');
   //Route::post('/plannedexhibition/add1', 'Analyst\PlannedexhibitionController@store1');
    //Route::get('/plannedexhibition/updreport/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@updreportform');
    //Route::post('/plannedexhibition/updreport', 'Analyst\PlannedexhibitionController@updreport');
    //Route::get('/plannedexhibition/add2/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@create2form');
    //Route::get('/plannedexhibition/add3/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@add3form');
   // Route::post('/plannedexhibition/add3/{flag?}', 'Analyst\PlannedexhibitionController@store3'); //++
    //Route::get('/plannedexhibition/article/{plannedexhibition}', 'Analyst\PlannedexhibitionController@article');
    //Route::delete('/plannedexhibition/{plannedexhibition}/delete_article', 'Analyst\PlannedexhibitionController@delete_article');
    //Route::delete('/plannedexhibition/{plannedexhibitionyear}/delete_year', 'Analyst\PlannedexhibitionController@delete_year');
   // Route::get('/plannedexhibition/upd/{plannedexhibition}', 'Analyst\PlannedexhibitionController@upd_form');
    //Route::put('/plannedexhibition/upd/{flag?}', 'Analyst\PlannedexhibitionController@update'); //+
    //Route::put('/plannedexhibition/publish/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@publish');
    /*Route::put('/plannedexhibition/for_approval/{plannedexhibitionyear}', 'Analyst\PlannedexhibitionController@for_approval');*/
    //Route::put('/plannedexhibition/article_publish/{plannedexhibition}', 'Analyst\PlannedexhibitionController@article_publish');
    //Route::put('/plannedexhibition/article_for_approval/{plannedexhibition}', 'Analyst\PlannedexhibitionController@article_for_approval');


    //Route::get('/various', 'Analyst\VariousController@list');
    //Route::get('/various/show/{variousreport}', 'Analyst\VariousController@item');
    //Route::get('/various/article/{variousarticle}/{variousreport?}', 'Analyst\VariousController@item_article');
   // Route::get('/various/add1', 'Analyst\VariousController@create1form');
    //Route::post('/various/add1', 'Analyst\VariousController@create1');
  //  Route::get('/various/updreport/{variousreport}', 'Analyst\VariousController@updreportform');
  //  Route::post('/various/updreport/{variousreport}', 'Analyst\VariousController@updreport');
  //  Route::delete('/various/{variousreport}/deletereport', 'Analyst\VariousController@delete_report');
  //  Route::delete('/various/{variouscategory}/deletecategory', 'Analyst\VariousController@delete_category');
  //  Route::delete('/various/{varioussubcategory}/deletesubcategory', 'Analyst\VariousController@delete_subcategory');
   // Route::delete('/various/{variousarticle}/deletearticle', 'Analyst\VariousController@delete_article');
  //  Route::get('/various/publish/{variousreport}', 'Analyst\VariousController@publish');
   // Route::get('/various/add2/{variousreport}', 'Analyst\VariousController@create2form');
  //  Route::post('/various/createcategory', 'Analyst\VariousController@createcategory');
 //   Route::post('/various/createsubcategory', 'Analyst\VariousController@createsubcategory');
   // Route::get('/various/add3/{variousreport}/{variouscategory?}/{varioussubcategory?}/', 'Analyst\VariousController@create3form');
    //Route::post('/various/add3/{flag?}', 'Analyst\VariousController@create3');//++
  //  Route::get('/various/upd/{variousarticle}', 'Analyst\VariousController@upd_form');
 //   Route::put('/various/upd/{flag?}', 'Analyst\VariousController@update');//++
 //   Route::put('/various/publish/{variousreport}', 'Analyst\VariousController@publish');
    /*Route::put('/various/for_approval/{variousreport}', 'Analyst\VariousController@for_approval');*/
 // Route::put('/various/article_publish/{variousarticle}/{variousreport}', 'Analyst\VariousController@article_publish');
  //  Route::put('/various/article_for_approval/{variousarticle}', 'Analyst\VariousController@article_for_approval');

    /*Report*/
	Route::get('/add1', 'Report\ReportController@report_add_form');
	Route::post('/add1', 'Report\ReportController@report_add');
	Route::get('/add2/{report}', 'Report\ReportController@report_step_2');
	Route::get('/add3/{report}/{category?}/{subcategory?}', 'Report\ReportController@report_step_3');
	Route::put('/article_publish/{article}', 'Report\ReportController@article_publish' );
	Route::post('/add3/{flag?}', 'Report\ReportController@create3');
	Route::delete('/delete_article/{article}', 'Report\ReportController@delete_article');
	Route::get('/upd/{article}', 'Report\ReportController@upd_form');
	Route::put('/upd/{flag?}', 'Report\ReportController@update');
	Route::put('/publish/{report}', 'Report\ReportController@publish');
	Route::get('/updreport/{report}', 'Report\ReportController@updreportform');
	Route::post('/updreport/{report}', 'Report\ReportController@updreport');
	Route::delete('/deletereport/{report}', 'Report\ReportController@delete_report');
	Route::post('/addcategory', 'Report\ReportController@createcategory');
	Route::get('/addcategory/{report}', 'Report\ReportController@createcategoryform');
	Route::post('/addsubcategory', 'Report\ReportController@createsubcategory');
	Route::delete('/deletesubcategory/{subcategory}', 'Report\ReportController@delete_subcategory');
	Route::get('/upd_category/{category}', 'Report\ReportController@upd_form_category');
	Route::put('/upd_category/{category}', 'Report\ReportController@update_category');
	Route::get('/upd_subcategory/{subcategory}', 'Report\ReportController@upd_form_subcategory');
	Route::put('/upd_subcategory/{subcategory}', 'Report\ReportController@update_subcategory');

});

/*
 * Manager routes
 *
 * */
Route::middleware('checkmanager')->prefix('manager')->group(function()
{
    Route::get('/', 'Manager\ManagerController@index');
    Route::get('/addform/{role}', 'Manager\ManagerController@adduserform');
    Route::post('/add/{role}', 'Manager\ManagerController@adduser');
    Route::get('/users/{role}', 'Manager\ManagerController@list');
    Route::get('/user/{user}', 'Manager\ManagerController@user_info');
    Route::delete('/users/{user}/delete', 'Manager\ManagerController@deluser');
    Route::get('/users/{user}/update', 'Manager\ManagerController@upduserform');
    Route::put('/users/{user}/update', 'Manager\ManagerController@upduser');

});
/*
 * Admin routes
 * */
Route::middleware('checkadmin')->group(function()
{
    Route::get('/stats/users/{user}', 'Admin\AdminController@users');
    Route::get('/stats/routes/', 'Admin\AdminController@count_visits');
    Route::get('/stats/routes/{route}', 'Admin\AdminController@count_visits_byroutes');

});

/*
 * PDF routes
 * */

Route::get('/{report}/pdf_subcategory/{id}/{id_cat?}/{id_sub?}', 'Pdf\PdfController@pdf_subcategory');

Route::get('/pdf_article/{id}', 'Pdf\PdfController@pdf_article');

Route::get('/pdf_item/{id}', 'Pdf\PdfController@pdf_item');

Route::get('/{report}/pdf_category/{id}/{cat_id?}', 'Pdf\PdfController@pdf_category');


/*
 * resources routes
 * */

Route::resource('/reporttypes', 'ReporttypeController');
Route::resource('/categories', 'CategoryController');
Route::resource('/subcategories', 'SubcategoryController');
Route::resource('/company', 'Analyst\resources\CompanyController');
Route::resource('/country', 'Analyst\resources\CountryController');
Route::resource('/vvttypes', 'Analyst\resources\VvttypesController');
Route::resource('/vvttypes', 'Analyst\resources\VvttypesController');
Route::resource('/personalities', 'Analyst\resources\PersonalitiesController');


/*
* CKeditor
**/

Route::post('upload-image', function(
  \Illuminate\Http\Request $request,
  Illuminate\Contracts\Validation\Factory $validator
) {
  $v = $validator->make($request->all(), [
      'upload' => 'required|image',
  ]);

  $funcNum = $request->input('CKEditorFuncNum');

  if ($v->fails()) {
      return response(
          "<script>
              window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$v->errors()->first()}');
          </script>"
      );
  }

  $image = $request->file('upload');
  $image->store('public/uploads');
  $url = asset('storage/uploads/'.$image->hashName()); // /opt/php71/bin/php artisan storage:link

  return response(
      "<script>
          window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Изображение успешно загружено');
      </script>"
  );
});
//Route::get('/test', 'IndexController@test');

Auth::routes();


