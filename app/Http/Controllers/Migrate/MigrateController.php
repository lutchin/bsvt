<?php
 
namespace App\Http\Controllers\Migrate;

use App\Category;
use App\Http\Controllers\Controller;
use App\models\analyst\yearly\Countrycatalog;
use App\models\analyst\yearly\InfoCountry;
use App\models\analyst\yearly\Region;
use Illuminate\Support\Facades\Auth;
use App\models\analyst\weekly\Weeklyarticle;
use App\models\analyst\weekly\Weeklyreport;
use App\models\analyst\monthly\Monthlyreport;
use App\models\analyst\monthly\Monthlyarticle;
use App\ReportType;
use App\Report;
use App\Image as ImageArticle;
use App\Models\Country;
use App\Models\Company;
use App\Models\VvtType;
use App\Models\Personality;
use App\ArticleReports;
use App\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MigrateController extends Controller
{
    public function __construct () {
        $this->middleware('auth');


    }

	public function migrate () {


		$reports = Weeklyreport::all();
		$count = 0;
    	foreach ( $reports as $report ) {


			$report_new = new Report();

		    $report_new->type_id = 1;
		    $report_new->date_start = $report->start_date;
		    $report_new->date_end = $report->end_date;
		    $report_new->status = $report->published;
		    $report_new->number = $report->number;
		    $report_new->created_at = $report->created_at;
		    $report_new->updated_at = $report->updated_at;
		    $report_new->save();

		    $categories = Category::where('report_type_id', $report_new->type_id )->get();

		    foreach( $categories as $category ) {

			    $weeklyarticles = Weeklyarticle::where( [
				    'weeklyreport_id' => $report->id,
				    'category_id'     => $category->id,
			    ] )->get();

			    foreach ( $weeklyarticles as $weeklyarticle ) {

				    $article = new ArticleReports();

				    $article->reports()->associate( $report_new );
				    $countries = Country::find( $weeklyarticle->countries );
				    $companies = Company::find( $weeklyarticle->company );
				    $vvttypes = VvtType::find( $weeklyarticle->vvtpypes );
				    $personalities = Personality::find( $weeklyarticle->personality );
				    $images = ImageArticle::find( $weeklyarticle->weeklyimages );

				    $article->category_id = $category->id;
				    $article->title       = $weeklyarticle->title;
				    $article->description = $weeklyarticle->body;
				    $article->date_start  = $weeklyarticle->start_period;
				    $article->date_end    = $weeklyarticle->end_period;
				    $article->status      = $weeklyarticle->published;
				    $article->created_at  = $weeklyarticle->created_at;
				    $article->updated_at  = $weeklyarticle->updated_at;
				    $article->save();
				    $count++;

				    if ( isset( $images ) ) {

					    foreach ( $images as $image ) {

						    $article->images()->save( $image );

					    }
				    }

				    if ( isset( $countries ) ) {

					    foreach ( $countries as $country ) {

						    $article->countries()->save( $country );

					    }
				    }

				    if ( isset( $companies ) ) {

					    foreach ( $companies as $company ) {

						    $article->companies()->save( $company );

					    }

				    }

				    if ( isset( $vvttypes ) ) {

					    foreach ( $vvttypes as $vvttype ) {

						    $article->$vvttypes()->save( $vvttype );

					    }

				    }

				    if ( isset( $personalities ) ) {


					    foreach ( $personalities as $personality ) {

						    $article->personalities()->save( $personality );

					    }

				    }


			    }

		    }


	    }

		return redirect()->to('/report/weekly')->with('status', $count. '  Статьи добавлены!');
	}

	public function migrate_one () {


		$reports = Monthlyreport::all();

		$count = 0;
		foreach ( $reports as $report ) {


			$report_new = new Report();

			$report_new->type_id = 2;
			$report_new->date_start = $report->start_date;
			$report_new->date_end = $report->end_date;
			$report_new->status = $report->published;
			$report_new->number = $report->number;
			$report_new->created_at = $report->created_at;
			$report_new->updated_at = $report->updated_at;
			$report_new->save();

			$categories = Category::where('report_type_id', $report_new->type_id )->get();
			//$subcategories = Subcategory::where('report_type_id', $report_new->type_id )->get();
			foreach( $categories as $category ) {

				$subcategories = Subcategory::where( 'category_id', $category->id )->get();

				foreach ( $subcategories as $subcategory ) {

					$weeklyarticles = Monthlyarticle::where( [
						'monthlyreport_id' => $report->id,
						'category_id'     => $category->id,
						'subcategory_id'  => $subcategory->id
					] )->get();

					foreach ( $weeklyarticles as $weeklyarticle ) {

						$article = new ArticleReports();

						$article->reports()->associate( $report_new );
						$countries     = Country::find( $weeklyarticle->countries );
						$companies     = Company::find( $weeklyarticle->company );
						$vvttypes      = VvtType::find( $weeklyarticle->vvtpypes );
						$personalities = Personality::find( $weeklyarticle->personality );
						$images        = ImageArticle::find( $weeklyarticle->weeklyimages );

						$article->category_id = $category->id;
						$article->subcategory_id = $subcategory->id;
						$article->title       = $weeklyarticle->title;
						$article->description = $weeklyarticle->body;
						$article->date_start  = $weeklyarticle->start_period;
						$article->date_end    = $weeklyarticle->end_period;
						$article->status      = $weeklyarticle->published;
						$article->created_at  = $weeklyarticle->created_at;
						$article->updated_at  = $weeklyarticle->updated_at;
						$article->save();
						$count ++;

						if ( isset( $images ) ) {

							foreach ( $images as $image ) {

								$article->images()->save( $image );

							}
						}

						if ( isset( $countries ) ) {

							foreach ( $countries as $country ) {

								$article->countries()->save( $country );

							}
						}

						if ( isset( $companies ) ) {

							foreach ( $companies as $company ) {

								$article->companies()->save( $company );

							}

						}

						if ( isset( $vvttypes ) ) {

							foreach ( $vvttypes as $vvttype ) {

								$article->$vvttypes()->save( $vvttype );

							}

						}

						if ( isset( $personalities ) ) {


							foreach ( $personalities as $personality ) {

								$article->personalities()->save( $personality );

							}

						}


					}

				}

			}
		}

		return redirect()->to('/report/monthly')->with('status', $count. '  Статьи добавлены!');
	}

	public function migrate_two () {


		$reports = Countrycatalog::all();

		$count = 0;
		foreach ( $reports as $report ) {


			$report_new = new Report();

			$report_new->type_id = 3;
			$report_new->date_start = $report->start_date;
			$report_new->date_end = $report->end_date;
			$report_new->status = $report->published;
			$report_new->number = $report->number;
			$report_new->created_at = $report->created_at;
			$report_new->updated_at = $report->updated_at;
			$report_new->save();

			$categories = Region::where('countrycatalog_id', $report->id )->get();

			//$subcategories = Subcategory::where('report_type_id', $report_new->type_id )->get();
			foreach( $categories as $category ) {

				$category_new = new Category();
				$category_new->title = $category->title;
				$category_new->description = $category->overview;
				//$category_new->date_start = $category->start_date;
				//$category_new->date_end = $category->end_date;
				$category_new->report_id = $report_new->id;
				$category_new->report_type_id = $report_new->type_id;
				$category_new->created_at = $category->created_at;
				$category_new->updated_at = $category->updated_at;

				$category_new->save();



				//$subcategories = Subcategory::where( 'category_id', $category->id )->get();

				//foreach ( $subcategories as $subcategory ) {

					$weeklyarticles = InfoCountry::where( [
						//'monthlyreport_id' => $report->id,
						'region_id'     => $category->id,
						//'subcategory_id'  => $subcategory->id
					] )->get();

					foreach ( $weeklyarticles as $weeklyarticle ) {

						$article = new ArticleReports();

						$article->reports()->associate( $report_new );
						$countries     = Country::find( $weeklyarticle->countries );
						$companies     = Company::find( $weeklyarticle->company );
						$vvttypes      = VvtType::find( $weeklyarticle->vvtpypes );
						$personalities = Personality::find( $weeklyarticle->personality );
						$images        = ImageArticle::find( $weeklyarticle->weeklyimages );

						$article->category_id = $category_new->id;
						//$article->subcategory_id = $subcategory->id;
						$article->title       = $weeklyarticle->title;
						$article->description = $weeklyarticle->overview;
						$article->date_start  = $weeklyarticle->start_date;
						$article->date_end    = $weeklyarticle->end_date;
						$article->status      = $weeklyarticle->published;
						$article->created_at  = $weeklyarticle->created_at;
						$article->updated_at  = $weeklyarticle->updated_at;
						$article->save();
						$count ++;

						if ( isset( $images ) ) {

							foreach ( $images as $image ) {

								$article->images()->save( $image );

							}
						}

						if ( isset( $countries ) ) {

							foreach ( $countries as $country ) {

								$article->countries()->save( $country );

							}
						}

						if ( isset( $companies ) ) {

							foreach ( $companies as $company ) {

								$article->companies()->save( $company );

							}

						}

						if ( isset( $vvttypes ) ) {

							foreach ( $vvttypes as $vvttype ) {

								$article->$vvttypes()->save( $vvttype );

							}

						}

						if ( isset( $personalities ) ) {


							foreach ( $personalities as $personality ) {

								$article->personalities()->save( $personality );

							}

						}


					}

				}

			}
	//	}

		return redirect()->to('/report/countrycatalog')->with('status', $count. '  Статьи добавлены!');
	}

    public function role () {

	    return Auth::user()->roles[0]->title;

    }

	public function delete () {

    	$reports = ArticleReports::where('report_id', 0)->get();

    	foreach ($reports as $report) {

		    $report->delete();
	    }

		return redirect()->to('/report/monthly')->with('status', 'обновлено');
	}

}
