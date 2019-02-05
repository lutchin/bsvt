<?php
namespace App\Http\Controllers\Pdf;

use App\ArticleReports;
use App\Report;
use App\Http\Controllers\Controller;
use App\models\analyst\yearly\Yearlyarticle;
use App\models\analyst\exhibitions\Plannedexhibition;
use App\models\analyst\yearly\InfoCountry;
use App\models\analyst\yearly\Countrycatalog;
use App\models\analyst\weekly\Weeklyarticle;
use App\models\analyst\weekly\Weeklyreport;
use App\models\analyst\monthly\Monthlyarticle;
use App\models\analyst\monthly\Monthlyreport;
use App\models\analyst\various\Variousarticle;
use App\models\analyst\yearly\Yearlycategory;
use App\models\analyst\yearly\Yearlyreport;
use App\models\analyst\various\Variousreport;
use App\models\analyst\various\Variouscategory;
use App\models\analyst\yearly\Yearlysubcategory;
use App\models\analyst\yearly\Region;
use App\models\analyst\exhibitions\Plannedexhibitionyear;
use App\ReportType;
use App\Category;
use App\Subcategory;


class PdfController extends Controller {

    protected $pdf;


	public function __construct () {
		$this->middleware('auth');
	}


	public function pdf_article ( $id ) {

		$article = ArticleReports::find($id);

		$report = $article->reports;
		$report_slug = $report->types->slug;
		$template = 'pdf.pdf_item';

		$category       = $article->category_id != false ? $article->category->title : false;
		$subcategory    = $article->subcategory_id != false ? $article->subcategory->title : false;
		$items[$category][$subcategory][] = $article;


		$pdf = \PDF::loadView($template, compact('report','items','report_slug'));

		return $pdf->stream( $report->types->title .'.pdf' );

	}

/**********************************************************************************************************************/
	public function pdf_item ( $id ) {

		$report = Report::find($id);
		$report_slug = $report->types->slug;

		if($report->types->slug == 'plannedexhibition'){

			$format = ['format' => 'A4-L'];

		} else {

			$format = ['format' => 'A4'];

		}

//		switch ($reports){
//
//			case 'weekly':
//				$article = $data_report = Weeklyreport::find($id);
//				$template = 'user.weeklyreview.pdf_item';
//				$find = 1;
//				$categories  = Category::where('report_type_id', 1)->get();
//				break;
//
//			case 'monthly':
//				$article = $data_report = Monthlyreport::find($id);
//				$template = 'user.monthlyreview.pdf_item';
//				$find = 2;
//				$start_date = $article->start_date;
//				break;
//
//			case 'countrycatalog':
//				$article = Countrycatalog::find($id);
//				$template = 'user.countrycatalog.pdf_item';
//				$find = 3;
//				$number = $article->number;
//				$start_date = $article->start_date;
//				$end_date = $article->end_date;
//				$data_report = $article->regions()->first();
//				break;
//
//			case 'yearly':
//				$article = $data_report = Yearlyreport::find($id);
//				$template = 'user.yearlyreview.pdf_item';
//				$number = $article->number;
//				$find = 4;
//				break;
//
//			case 'plannedexhibition':
//				$article = $data_report =  Plannedexhibitionyear::find($id);
//				$report = $article ->plannedexhibitions()->latest('id')->paginate(100)->items();
//				$template = 'pdf.plan_list';
//				$find = 5;
//				$format = ['format' => 'A4-L'];
//				break;
//
//			case 'various':
//				$report = $data_report = Variousreport::find($id);
//				$template = 'user.various.pdf_item';
//				$find = 7;
//				break;
//
//		}
//
//		$reporttitle = ReportType::find($find)->title;
//
//		if($reports == 'monthly') {
//
//			$articles = $article->articles()->with(['category', 'subcategory'])->get();
//
//			if ( $articles->count() !== 0 ) {
//				foreach ( $articles as $article ) {
//
//					$category                           = $article->category != NULL ? $article->category->title : 'false';
//					$subcategory                        = $article->subcategory != NULL ? $article->subcategory->title : 'false';
//					$report[ $category ][ $subcategory ][] = $article;
//
//				}
//			}
//
//		}
//
//		if ($reports == 'yearly') {
//
//			$report = $article->articlesReport->merge($article->categories()->with('subcategories', 'subcategories.articles','articles')->get());
//		}
//
//		if ($reports == 'countrycatalog') {
//
//			$report = $article->regions()->with( 'countries')->get();
//		}
//
//		if ($reports == 'weekly') {
//
//			$articles = $article->articles()->with('category')->get();
//
//			if ( $articles->count() !== 0 ) {
//
//				$report = $articles->mapToGroups(function( $item, $key )
//				{
//					if ( $item->category !== NULL ) {
//
//						return [$item->category->title => $item];
//					}
//					else {
//						return [0 => NULL];
//					}
//				});
//			}
//
//		}

		if (  $report->types->slug == 'weekly' || $report->types->slug == 'monthly' ) {

			$categories  = Category::where('report_type_id', $report->types->id)->get();

		} else {
			$categories  = Category::where('report_id', $report->id)->get();
		}

		if($report_slug != 'plannedexhibition') {
			$articles    = $report->articles()->with('category')->get();
			$subcategories = Subcategory::whereIn('id',array_unique($articles->pluck('subcategory_id')->toArray()))->
			select('id','title')->get();

			foreach ($articles as $article) {
				if ($article->category_id)
					foreach ($categories as $category) {
						if ($article->category_id == $category->id) {
							$subcategory = $article->subcategory_id != false ? $subcategories->where('id',$article->subcategory_id)->first()->title: false;
							$items[$category->title][$subcategory] [] = $article;

						}
					}
				else {
					$subcategory = $article->subcategory_id != false ? $subcategories->where('id',$article->subcategory_id)->first()->title : false;
					$items[false][$subcategory] [] = $article;
				}
			}

			foreach ($categories as $category) {
				$descriptions[] = $category->description;
			}

//		dd($descriptions);
//		dd($items);

			$template = 'pdf.pdf_item';
			$pdf = \PDF::loadView($template, compact('report', 'items','report_slug','descriptions'), [], $format);
		}
		else {
			$template = 'pdf.plan_list';
			$items = $report->articles()->with('category')->get();
			$pdf = \PDF::loadView($template, compact('report','items','report_slug'), [], $format);
		}



		return $pdf->stream( $this->setTitle( $report ) .'.pdf' );

	}

/**********************************************************************************************************************/
	public function pdf_category ($report_id,$category_id) {

		$report = Report::find($report_id);
		$report_slug = $report->types->slug;

		$template = 'pdf.pdf_item';
		$articles = $report->articles()->where('category_id',$category_id)->get();

		if($articles->count() !== 0) {

			$category = Category::find($category_id);
			foreach ($articles as $index => $art) {

					$subcategory = $art->subcategory_id != false ? $art->subcategory->title : false;
					$items[$category->title][$subcategory][] = $art;

			}
			$descriptions[] = $category->description;
		}

//		dd($items);
		//dd($report_array);

		$pdf = \PDF::loadView($template, compact('report','items','report_slug','descriptions'));
		return $pdf->stream( $report->types->title.'.pdf' );

	}

/**********************************************************************************************************************/
	public function pdf_subcategory ($report_id , $id_cat, $id_sub) {

		$report = Report::find($report_id);
		$report_slug = $report->types->slug;

		$template = 'pdf.pdf_item';
			$articles = $report->articles()->where(['category_id'=> $id_cat, 'subcategory_id'=> $id_sub])->get();
				if ( $articles->count() !== 0 ) {
					$items = [];
					foreach ( $articles as $index => $article ) {

					$category       = $article->category_id != false ? $article->category->title : false;
					$subcategory    = $article->subcategory_id != false ? $article->subcategory->title : false;
					$items[ $category ][ $subcategory ][] = $article;
				}
			}

		//dd($report_array);

		$pdf = \PDF::loadView($template, compact('report','items','report_slug'));
		return $pdf->stream( $report->types->title.'.pdf' );

	}

/**********************************************************************************************************************/
	public function setTitle( $report ){

		switch ( $report->types->slug ) {

			case 'weekly':
				$title = $report->types->description .' № '.$report->number.' за период от '.date("d.m.y",$report->date_start).
				         ' до '.date("d.m.y",$report->date_end);
				break;
			case 'monthly':
				$title = $report->types->description .' № '.$report->number.' за '.$this->m_name(date("m",$report->date_start)).
				         ' '.date("Y",$report->date_start);
				break;
			case 'yearly':
				$title = $report->types->description .' за '.date( "Y", $report->date_start ).' год.';
				break;
			case 'countrycatalog':
				$title = $report->types->description .' за '.date("Y",$report->date_end).' год.';
				break;
			case 'plannedexhibition':
				$title = 'Основные международные выставки в '. date("Y",$report->date_end).' году';
				break;
			case 'various':
				$title = $report->number;
				break;
		}


		return $title;

	}

	public function m_name ( $m ) {
		switch ( $m ) {
			case 1:
				$m_name = 'январь';
				break;
			case 2:
				$m_name = 'февраль';
				break;
			case 3:
				$m_name = 'март';
				break;
			case 4:
				$m_name = 'апрель';
				break;
			case 5:
				$m_name = 'май';
				break;
			case 6:
				$m_name = 'июнь';
				break;
			case 7:
				$m_name = 'июль';
				break;
			case 8:
				$m_name = 'август';
				break;
			case 9:
				$m_name = 'сентябрь';
				break;
			case 10:
				$m_name = 'октябрь';
				break;
			case 11:
				$m_name = 'ноябрь';
				break;
			case 12:
				$m_name = 'декабрь';
				break;
			default:
				$m      = "Ошибка даты";
				$m_name = "";
				break;

		}

		return $m_name;
	}

}