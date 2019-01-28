<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Http\Controllers\Controller;
use App\models\analyst\exhibitions\Plannedexhibition;
use App\models\analyst\exhibitions\Plannedexhibitionyear;
use App\models\analyst\monthly\Monthlyarticle;
use App\models\analyst\monthly\Monthlyreport;
use App\models\analyst\various\Variousarticle;
use App\models\analyst\various\Variousreport;
use App\models\analyst\weekly\Weeklyarticle;
use App\models\analyst\weekly\Weeklyreport;
use App\models\analyst\yearly\Countrycatalog;
use App\models\analyst\yearly\InfoCountry;
use App\models\analyst\yearly\Yearlyarticle;
use App\models\analyst\yearly\Yearlyreport;
use App\Models\Company;
use App\Models\Country;
use App\Models\Personality;
use App\Models\VvtType;
use App\ReportType;
use App\User;
use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index () {
        $week_articles           = Weeklyreport::latest('start_date')->active()->take(3)->get();
        $month_articles          = Monthlyreport::latest('start_date')->active()->take(3)->get();
        $year_articles           = Yearlyreport::latest('start_date')->active()->take(3)->get();
        $various_articles        = Variousreport::latest('start_date')->active()->take(3)->get();
        $countrycatalogs         = Countrycatalog::latest('start_date')->active()->take(3)->get();
        $plannedexhibitionsyears = Plannedexhibitionyear::latest('start_date')->active()->take(3)->get();


        return view('user.home', compact('title', 'week_articles', 'month_articles', 'year_articles', 'various_articles', 'countrycatalogs', 'plannedexhibitionsyears'));
    }

    public function cabinet ( User $user ) {

        $role = $user->roles->first();

        return view('user.cabinet', compact('user', 'role'));
    }

    public function search ( Request $request, $quote = null ) {

        $result = [];

	    if($request->ajax()){

		    $q = $request->q;

	    } else {

		    $q      = strip_tags($quote);

	    }


        $plannedexibitions = Plannedexhibition::search($q)->active()->get();

        if ( $plannedexibitions->count() != 0 ) {
            $result[ 'plannedexhibition' ] = $plannedexibitions;
        }
        /*$exibitions = Exhibition::search($q, NULL, TRUE, TRUE)->active()->get();
        if ( $exibitions->count() != 0 ) {
            $result[ 'exhibition' ] = $exibitions;
        }*/
        $weeklyarticle = Weeklyarticle::search($q)->active()->get();
        if ( $weeklyarticle->count() != 0 ) {
            $result[ 'weekly' ] = $weeklyarticle;
        }
        $monthlyarticle = Monthlyarticle::search($q)->active()->get();
        if ( $monthlyarticle->count() != 0 ) {
            $result[ 'monthly' ] = $monthlyarticle;
        }
        $variousarticle = Variousarticle::search($q)->active()->get();
        if ( $variousarticle->count() != 0 ) {
            $result[ 'various' ] = $variousarticle;
        }
        $infocountries = InfoCountry::search($q)->active()->get();
        if ( $infocountries->count() != 0 ) {
            $result[ 'countrycatalog' ] = $infocountries;
        }
        $yearlyarticles = Yearlyarticle::search($q)->active()->get();
        if ( $yearlyarticles->count() != 0 ) {
            $result[ 'yearly' ] = $yearlyarticles;
        }


	    if($request->ajax()){

		    foreach( $plannedexibitions as $plannedexibition) {

			   $plannedexibition->titleTags($plannedexibition->title);

            }

		    return   $result;

	    }

        return view('user.simplysearch', compact('result'));
    }

    public function advanced_search_form () {
        $countries         = Country::orderBy('title')->get();
        $companies         = Company::orderBy('title')->get();
        $vvt_types         = VvtType::orderBy('title')->get();
        $personalities     = Personality::orderBy('title')->get();
        $report_types      = \App\ReportType::$data;
        $weeklycategories  = Category::where('report_type_id', 1)->get();
        $monthlycategories = Category::where('report_type_id', 2)->get();

        return view('user.advan_search', compact('report_types', 'result', 'countries', 'companies', 'vvt_types', 'personalities', 'weeklycategories', 'monthlycategories'));
    }

    public function advanced_search ( Request $request ) {

        $start_period  = $request->input('start_period');
        $end_period    = $request->input('end_period');
        $countries     = $request->input('countries') ? Country::whereIn('id', $request->input('countries'))
                                                               ->get() : collect([]);
        $companies     = $request->input('companies') ? Company::whereIn('id', $request->input('companies'))
                                                               ->get() : collect([]);
        $personalities = $request->input('personalities') ? Personality::whereIn('id', $request->input('personalities'))
                                                                       ->get() : collect([]);
        $vvt_types     = $request->input('vvt_types') ? VvtType::whereIn('id', $request->input('vvt_types'))
                                                               ->get() : collect([]);
        $report_type   = ReportType::where('slug', $request->input('report_type'))
                                   ->first() ? ReportType::where('slug', $request->input('report_type'))
                                                                               ->first() : $request->input('report_type');
        $report_slug = ReportType::where('slug', $request->input('report_type'))
                                 ->first() ? ReportType::where('slug', $request->input('report_type'))
                                                                             ->first()->slug : $request->input('report_type');
        $new_weekly    = (int) $request->input('new_weekly');
        $new_monthly   = (int) $request->input('new_monthly');
        if ( $countries->count() == 0 and $companies->count() == 0 and $personalities->count() == 0 and $vvt_types->count() == 0 ) {
            //поиск без учета тегов

            switch ( $report_slug ) {
                case 'all_reports':
                    $this->findinalltables($start_period, $end_period, $articles);
                    break;
                case 'weekly':
                    if ( $new_weekly === 0 ) {
                        foreach ( Weeklyarticle::where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'weekly' ][ $item->id ] = $item;
                        }
                    }
                    else {
                        foreach ( Weeklyarticle::where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            if ( $item->category->id == Category::find($new_weekly)->id ) {
                                $articles[ 'weekly' ][ $item->id ] = $item;
                            }
                        }
                    }

                    break;
                case 'monthly':
                    if ( $new_monthly === 0 ) {
                        foreach ( Monthlyarticle::where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'monthly' ][ $item->id ] = $item;
                        }
                    }
                    else {
                        foreach ( Monthlyarticle::where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            if ( $item->category->id == Category::find($new_monthly)->id ) {
                                $articles[ 'monthly' ][ $item->id ] = $item;
                            }
                        }
                    }

                    break;
                case 'countrycatalog':
                    foreach ( InfoCountry::where([
                      ['start_date', '>=', $start_period],
                      ['end_date', '<=', $end_period],
                    ])->active()->get() as $item ) {
                        $articles[ 'countrycatalog' ][ $item->id ] = $item;
                    }

                    break;
                case 'yearly':
                    foreach ( Yearlyarticle::where([
                      ['start_period', '>=', $start_period],
                      ['end_period', '<=', $end_period],
                    ])->active()->get() as $item ) {
                        $articles[ 'yearly' ][ $item->id ] = $item;
                    }

                    break;
                case 'plannedexhibition':
                    foreach ( Plannedexhibition::where([
                      ['start', '>=', $start_period],
                      ['fin', '<=', $end_period],
                    ])->active()->get() as $item ) {
                        $articles[ 'plannedexhibition' ][ $item->id ] = $item;
                    }
                    break;
                case 'various':
                    foreach ( Variousarticle::where([
                      ['start_period', '>=', $start_period],
                      ['end_period', '<=', $end_period],
                    ])->active()->get() as $item ) {
                        $articles[ 'various' ][ $item->id ] = $item;
                    }
                    break;
            }
        }
        else {
            //поиск с учетом тегов
            //Получаем количество отмеченных тегов
            $tags_count = $countries->count() + $companies->count() + $vvt_types->count() + $personalities->count();

            switch ( $report_slug ) {
                case 'all_reports':
                    //поиск по всем таблицам
                    $this->findbytagsinalltables($countries, $companies, $vvt_types, $personalities, $start_period, $end_period, $articles);
                    break;
                case 'weekly':
                    if ( $new_weekly === 0 ) {
                        foreach ( $countries as $country ) {
                            foreach ( $country->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'weekly' ][] = $item;
                            }
                        }
                        foreach ( $companies as $company ) {
                            foreach ( $company->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'weekly' ][] = $item;
                            }
                        }
                        foreach ( $vvt_types as $vvt_type ) {
                            foreach ( $vvt_type->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'weekly' ][] = $item;
                            }
                        }
                        foreach ( $personalities as $personality ) {
                            foreach ( $personality->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'weekly' ][] = $item;
                            }
                        }
                    }
                    else {
                        foreach ( $countries as $country ) {
                            foreach ( $country->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_weekly)->id ) {
                                    $articles[ 'weekly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $companies as $company ) {
                            foreach ( $company->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_weekly)->id ) {
                                    $articles[ 'weekly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $vvt_types as $vvt_type ) {
                            foreach ( $vvt_type->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_weekly)->id ) {
                                    $articles[ 'weekly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $personalities as $personality ) {
                            foreach ( $personality->weeklyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_weekly)->id ) {
                                    $articles[ 'weekly' ][] = $item;
                                }
                            }
                        }
                    }
                    //отбираем недельные статьи которые вытянулсь на каждый тег
                    if ( isset($articles[ 'weekly' ]) ) {
                        //группируем все стаьи
                        foreach ( collect($articles[ 'weekly' ])->groupBy('id') as $value ) {
                            //если одна запись вытянулась на каждый тег
                            if ( $value->count() == $tags_count ) {
                                //добавляем ее в массив, передаваемый во вьюху
                                $strong[ 'weekly' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
                case 'monthly':
                    if ( $new_monthly === 0 ) {
                        foreach ( $countries as $country ) {
                            foreach ( $country->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'monthly' ][] = $item;
                            }
                        }
                        foreach ( $companies as $company ) {
                            foreach ( $company->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'monthly' ][] = $item;
                            }
                        }
                        foreach ( $vvt_types as $vvt_type ) {
                            foreach ( $vvt_type->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'monthly' ][] = $item;
                            }
                        }
                        foreach ( $personalities as $personality ) {
                            foreach ( $personality->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                $articles[ 'monthly' ][] = $item;
                            }
                        }
                    }
                    else {
                        foreach ( $countries as $country ) {
                            foreach ( $country->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_monthly)->id ) {
                                    $articles[ 'monthly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $companies as $company ) {
                            foreach ( $company->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_monthly)->id ) {
                                    $articles[ 'monthly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $vvt_types as $vvt_type ) {
                            foreach ( $vvt_type->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_monthly)->id ) {
                                    $articles[ 'monthly' ][] = $item;
                                }
                            }
                        }
                        foreach ( $personalities as $personality ) {
                            foreach ( $personality->monthlyarticles()->where([
                              ['start_period', '>=', $start_period],
                              ['end_period', '<=', $end_period],
                            ])->active()->get() as $item ) {
                                if ( $item->category->id == Category::find($new_monthly)->id ) {
                                    $articles[ 'monthly' ][] = $item;
                                }
                            }
                        }
                    }
                    //отбираем недельные статьи которые вытянулсь на каждый тег
                    if ( isset($articles[ 'monthly' ]) ) {
                        //группируем все стаьи
                        foreach ( collect($articles[ 'monthly' ])->groupBy('id') as $value ) {
                            //если одна запись вытянулась на каждый тег
                            if ( $value->count() == $tags_count ) {
                                //добавляем ее в массив, передаваемый во вьюху
                                $strong[ 'monthly' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
                case 'countrycatalog':
                    foreach ( $countries as $country ) {
                        foreach ( $country->countrycatalogarticles()->where([
                          ['start_date', '>=', $start_period],
                          ['end_date', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'countrycatalog' ][] = $item;
                        }
                    }
                    foreach ( $companies as $company ) {
                        foreach ( $company->countrycatalogarticles()->where([
                          ['start_date', '>=', $start_period],
                          ['end_date', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'countrycatalog' ][] = $item;
                        }
                    }
                    foreach ( $vvt_types as $vvt_type ) {
                        foreach ( $vvt_type->countrycatalogarticles()->where([
                          ['start_date', '>=', $start_period],
                          ['end_date', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'countrycatalog' ][] = $item;
                        }
                    }
                    foreach ( $personalities as $personality ) {
                        foreach ( $personality->countrycatalogarticles()->where([
                          ['start_date', '>=', $start_period],
                          ['end_date', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'countrycatalog' ][] = $item;
                        }
                    }
                    //отбираем  статьи справочника государств которые вытянулсь на каждый тег
                    if ( isset($articles[ 'countrycatalog' ]) ) {
                        foreach ( collect($articles[ 'countrycatalog' ])->groupBy('id') as $value ) {
                            if ( $value->count() == $tags_count ) {
                                $strong[ 'countrycatalog' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
                case 'yearly':
                    foreach ( $countries as $country ) {
                        foreach ( $country->yearlyarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'yearly' ][] = $item;
                        }
                    }
                    foreach ( $companies as $company ) {
                        foreach ( $company->yearlyarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'yearly' ][] = $item;
                        }

                    }
                    foreach ( $vvt_types as $vvt_type ) {
                        foreach ( $vvt_type->yearlyarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'yearly' ][] = $item;
                        }
                    }
                    foreach ( $personalities as $personality ) {
                        foreach ( $personality->yearlyarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'yearly' ][] = $item;
                        }
                    }
                    //отбираем ежегодных статей которые вытянулсь на каждый тег
                    if ( isset($articles[ 'yearly' ]) ) {

                        foreach ( collect($articles[ 'yearly' ])->groupBy('id') as $value ) {
                            if ( $value->count() == $tags_count ) {
                                $strong[ 'yearly' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
                case 'plannedexhibition':
                    foreach ( $countries as $country ) {
                        foreach ( $country->plannedexhibitionarticles()->where([
                          ['start', '>=', $start_period],
                          ['fin', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'plannedexhibition' ][] = $item;
                        }
                    }
                    foreach ( $companies as $company ) {
                        foreach ( $company->plannedexhibitionarticles()->where([
                          ['start', '>=', $start_period],
                          ['fin', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'plannedexhibition' ][] = $item;
                        }
                    }
                    foreach ( $vvt_types as $vvt_type ) {
                        foreach ( $vvt_type->plannedexhibitionarticles()->where([
                          ['start', '>=', $start_period],
                          ['fin', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'plannedexhibition' ][] = $item;
                        }
                    }
                    foreach ( $personalities as $personality ) {
                        foreach ( $personality->plannedexhibitionarticles()->where([
                          ['start', '>=', $start_period],
                          ['fin', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'plannedexhibition' ][] = $item;
                        }
                    }
                    //отбираем  статьи о запланированных выставках которые вытянулсь на каждый тег
                    if ( isset($articles[ 'plannedexhibition' ]) ) {

                        foreach ( collect($articles[ 'plannedexhibition' ])->groupBy('id') as $value ) {
                            if ( $value->count() == $tags_count ) {
                                $strong[ 'plannedexhibition' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
                case 'various':
                    foreach ( $countries as $country ) {
                        foreach ( $country->variousarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'various' ][] = $item;
                        }
                    }
                    foreach ( $companies as $company ) {

                        foreach ( $company->variousarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'various' ][] = $item;
                        }

                    }
                    foreach ( $vvt_types as $vvt_type ) {

                        foreach ( $vvt_type->variousarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'various' ][] = $item;
                        }

                    }
                    foreach ( $personalities as $personality ) {
                        foreach ( $personality->variousarticles()->where([
                          ['start_period', '>=', $start_period],
                          ['end_period', '<=', $end_period],
                        ])->active()->get() as $item ) {
                            $articles[ 'various' ][] = $item;
                        }
                    }
                    //отбираем  статей иных материалов которые вытянулсь на каждый тег
                    if ( isset($articles[ 'various' ]) ) {

                        foreach ( collect($articles[ 'various' ])->groupBy('id') as $value ) {
                            if ( $value->count() == $tags_count ) {
                                $strong[ 'various' ][] = $value->first();
                            }
                        };
                    }
                    $articles = isset($strong) ? $strong : collect([]);
                    break;
            }

        }

        return view('user.advan_search_result', compact('articles', 'report_type', 'start_period', 'end_period', 'countries', 'companies', 'personalities', 'vvt_types'));
    }

    public function findinalltables ( $start_period, $end_period, &$articles ) {
//foreach ( Weeklyarticle::without_tags()->where([
        foreach ( Weeklyarticle::where([
          ['start_period', '>=', $start_period],
          ['end_period', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'weekly' ][ $item->id ] = $item;
        };

        foreach ( Monthlyarticle::where([
          ['start_period', '>=', $start_period],
          ['end_period', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'monthly' ][ $item->id ] = $item;
        }

        foreach ( InfoCountry::where([
          ['start_date', '>=', $start_period],
          ['end_date', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'countrycatalog' ][ $item->id ] = $item;
        }

        foreach ( Yearlyarticle::where([
          ['start_period', '>=', $start_period],
          ['end_period', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'yearly' ][ $item->id ] = $item;
        }

        foreach ( Plannedexhibition::where([
          ['start', '>=', $start_period],
          ['fin', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'plannedexhibition' ][ $item->id ] = $item;
        }

        /*foreach ( Exhibition::without_tags()->where([
          ['startdate', '>=', $start_period],
          ['enddate', '<=', $end_period],
        ])->active()->get() as $item ) {
            $articles[ 'exhibition' ][ $item->id ] = $item;
        }*/

        foreach ( Variousarticle::where([
          ['start_period', '>=', $start_period],
          ['end_period', '<=', $end_period],
        ])->active()->paginate(30) as $item ) {
            $articles[ 'various' ][ $item->id ] = $item;
        }

        return $articles;
    }

    public function findbytagsinalltables ( $countries, $companies, $vvt_types, $personalities, $start_period, $end_period, &$articles ) {

        //поиск всех статей содержащих указанные метки и упаковывание в ассоциативный массив
        foreach ( $countries as $country ) {
            foreach ( $country->weeklyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'weekly' ][] = $item;
            }

            foreach ( $country->monthlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'monthly' ][] = $item;
            }

            foreach ( $country->yearlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'yearly' ][] = $item;
            }

            foreach ( $country->variousarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'various' ][] = $item;
            }

            foreach ( $country->plannedexhibitionarticles()->where([
              ['start', '>=', $start_period],
              ['fin', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'plannedexhibition' ][] = $item;
            }

            foreach ( $country->countrycatalogarticles()->where([
              ['start_date', '>=', $start_period],
              ['end_date', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'countrycatalog' ][] = $item;
            }

            /*foreach ( $country->exhibitionarticles()->where([
              ['startdate', '>=', $start_period],
              ['enddate', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'exhibition' ][] = $item;
            }*/

        }
        foreach ( $companies as $company ) {
            foreach ( $company->weeklyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'weekly' ][] = $item;
            }
            foreach ( $company->monthlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'monthly' ][] = $item;
            }
            foreach ( $company->yearlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'yearly' ][] = $item;
            }
            foreach ( $company->variousarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'various' ][] = $item;
            }
            foreach ( $company->plannedexhibitionarticles()->where([
              ['start', '>=', $start_period],
              ['fin', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'plannedexhibition' ][] = $item;
            }
            foreach ( $company->countrycatalogarticles()->where([
              ['start_date', '>=', $start_period],
              ['end_date', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'countrycatalog' ][] = $item;
            }
            /*foreach ( $company->exhibitionarticles()->where([
              ['startdate', '>=', $start_period],
              ['enddate', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'exhibition' ][] = $item;
            }*/
        }
        foreach ( $vvt_types as $vvt_type ) {
            foreach ( $vvt_type->weeklyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'weekly' ][] = $item;
            }
            foreach ( $vvt_type->monthlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'monthly' ][] = $item;
            }
            foreach ( $vvt_type->yearlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'yearly' ][] = $item;
            }
            foreach ( $vvt_type->variousarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'various' ][] = $item;
            }
            foreach ( $vvt_type->plannedexhibitionarticles()->where([
              ['start', '>=', $start_period],
              ['fin', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'plannedexhibition' ][] = $item;
            }
            foreach ( $vvt_type->countrycatalogarticles()->where([
              ['start_date', '>=', $start_period],
              ['end_date', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'countrycatalog' ][] = $item;
            }
            /*foreach ( $vvt_type->exhibitionarticles()->where([
              ['startdate', '>=', $start_period],
              ['enddate', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'exhibition' ][] = $item;
            }*/
        }
        foreach ( $personalities as $personality ) {
            foreach ( $personality->weeklyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'weekly' ][] = $item;
            }
            foreach ( $personality->monthlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'monthly' ][] = $item;
            }
            foreach ( $personality->yearlyarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'yearly' ][] = $item;
            }
            foreach ( $personality->variousarticles()->where([
              ['start_period', '>=', $start_period],
              ['end_period', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'various' ][] = $item;
            }
            foreach ( $personality->plannedexhibitionarticles()->where([
              ['start', '>=', $start_period],
              ['fin', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'plannedexhibition' ][] = $item;
            }
            foreach ( $personality->countrycatalogarticles()->where([
              ['start_date', '>=', $start_period],
              ['end_date', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'countrycatalog' ][] = $item;
            }
            /*foreach ( $personality->exhibitionarticles()->where([
              ['startdate', '>=', $start_period],
              ['enddate', '<=', $end_period],
            ])->active()->get() as $item ) {
                $articles[ 'exhibition' ][] = $item;
            }*/
        }

        //Получаем количество отмеченных тегов
        $tags_count = $countries->count() + $companies->count() + $vvt_types->count() + $personalities->count();
        //отбираем недельные статьи которые вытянулсь на каждый тег
        if ( isset($articles[ 'weekly' ]) ) {
            //группируем все стаьи
            foreach ( collect($articles[ 'weekly' ])->groupBy('id') as $value ) {
                //если одна запись вытянулась на каждый тег
                if ( $value->count() == $tags_count ) {
                    //добавляем ее в массив, передаваемый во вьюху
                    $strong[ 'weekly' ][] = $value->first();
                }
            };
        }
        //отбираем месячные статьи которые вытянулсь на каждый тег
        if ( isset($articles[ 'monthly' ]) ) {
            foreach ( collect($articles[ 'monthly' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'monthly' ][] = $value->first();
                }
            };
        }
        //отбираем ежегодных статей которые вытянулсь на каждый тег
        if ( isset($articles[ 'yearly' ]) ) {

            foreach ( collect($articles[ 'yearly' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'yearly' ][] = $value->first();
                }
            };
        }
        //отбираем  статей иных материалов которые вытянулсь на каждый тег
        if ( isset($articles[ 'various' ]) ) {

            foreach ( collect($articles[ 'various' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'various' ][] = $value->first();
                }
            };
        }
        //отбираем  статьи о запланированных выставках которые вытянулсь на каждый тег
        if ( isset($articles[ 'plannedexhibition' ]) ) {

            foreach ( collect($articles[ 'plannedexhibition' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'plannedexhibition' ][] = $value->first();
                }
            };
        }
        //отбираем статьи о прошедших выставках которые вытянулсь на каждый тег
        /*if ( isset($articles[ 'exhibition' ]) ) {
            foreach ( collect($articles[ 'exhibition' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'exhibition' ][] = $value->first();
                }
            };
        }*/
        //отбираем  статьи справочника государств которые вытянулсь на каждый тег
        if ( isset($articles[ 'countrycatalog' ]) ) {

            foreach ( collect($articles[ 'countrycatalog' ])->groupBy('id') as $value ) {
                if ( $value->count() == $tags_count ) {
                    $strong[ 'countrycatalog' ][] = $value->first();
                }
            };
        }

        $articles = isset($strong) ? $strong : collect([]);

        return $articles;
    }

    public function apisearch ( Request $request ) {

        if ( $request->input('q') != '' ) {
            $result = [];
            $q      = strip_tags($request->input('q'));

            if ( !strlen($q) ) {
                return 0;
            }

            $plannedexibitions = Plannedexhibition::search($q)->active()->take(5)->get();
            if ( $plannedexibitions->count() != 0 ) {
                $result[ 'plannedexhibition' ] = $plannedexibitions;
            }
            /* $exibitions = Exhibition::search($q, NULL, TRUE, TRUE)->active()->take(2)->get();
             if ( $exibitions->count() != 0 ) {
                 $result[ 'exhibition' ] = $exibitions;
             }*/
            $weeklyarticle = Weeklyarticle::search($q)->active()->take(2)->get();
            if ( $weeklyarticle->count() != 0 ) {
                $result[ 'weekly' ] = $weeklyarticle;
            }
            $monthlyarticle = Monthlyarticle::search($q)->active()->take(2)->get();
            if ( $monthlyarticle->count() != 0 ) {
                $result[ 'monthly' ] = $monthlyarticle;
            }
            $variousarticle = Variousarticle::search($q)->active()->take(2)->get();
            if ( $variousarticle->count() != 0 ) {
                $result[ 'various' ] = $variousarticle;
            }
            $infocountries = InfoCountry::search($q)->active()->take(2)->get();
            if ( $infocountries->count() != 0 ) {
                $result[ 'countrycatalog' ] = $infocountries;
            }
            $yearlyarticles = Yearlyarticle::search($q)->active()->take(2)->get();
            if ( $yearlyarticles->count() != 0 ) {
                $result[ 'yearly' ] = $yearlyarticles;
            }

            return $result;
        }
        else {
            return 0;
        }
    }

    public function bug(Request $request){

    	if($request) {

    		$theme = $request->input('theme');
    		$message = $request->input('text');

		    if ( $request->file('file') ) {

		    	$file = $request->file('file');

				$fileName = time() . '_' . $file->getClientOriginalName();
				$file->storeAs('email_photo', $fileName, ['disk' => 'bsvt']);

		    }

	    }
		switch ($theme){
			case 'info':
				$theme_mail = 'Информация на сайте';
				break;
			case 'error':
				$theme_mail = 'Ошибка в работе сайта';
				break;
			case 'suggestion':
				$theme_mail = 'Предложения/пожелания по сайту';
				break;
			case 'registration':
				$theme_mail = 'Регистрация/авторизация';
				break;
			case 'other':
				$theme_mail = 'Другие вопросы и комментарии';
				break;
		}
			    $objMail = new \stdClass();
			    $objMail->url = $request->input('url');
			    $objMail->subject= $theme_mail;
			    $objMail->text = $message;
			    $objMail->sender = Auth::user()->name." ".Auth::user()->surname;
			    $objMail->email = Auth::user()->email;
			    if(isset($fileName)) {

				    $objMail->path = $fileName;

			    }



	    Mail::to("lutchin@gmail.com")
	        ->cc("it@bsvt.by")
	        ->send(new SendEmail($objMail));

    	return redirect()->back()->with('status', 'Сообщение отправлено');
    }
}
