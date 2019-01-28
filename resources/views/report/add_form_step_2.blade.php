<?php

function m_name($m) {
	switch ( $m ) {
	    case 1:
	        $m_name = 'января';
	        break;
	    case 2:
	        $m_name = 'февраля';
	        break;
	    case 3:
	        $m_name = 'марта';
	        break;
	    case 4:
	        $m_name = 'апреля';
	        break;
	    case 5:
	        $m_name = 'мая';
	        break;
	    case 6:
	        $m_name = 'июня';
	        break;
	    case 7:
	        $m_name = 'июля';
	        break;
	    case 8:
	        $m_name = 'августа';
	        break;
	    case 9:
	        $m_name = 'сентября';
	        break;
	    case 10:
	        $m_name = 'октября';
	        break;
	    case 11:
	        $m_name = 'ноября';
	        break;
	    case 12:
	        $m_name = 'декабря';
	        break;
	    default:
	        $m      = "Ошибка даты";
	        $m_name = "";
	        break;
	
	}
	return $m_name;
}

?>
@extends('layouts.app')

@section('content')
    <div class="container add_form_step2 posr">

        <h3 class="title">{{ $report->types->description }}
			@if( $report->types->slug == 'weekly' || $report->types->slug == 'monthly' )
			№ {{ $report->number }} за период от {{date("d",$report->date_start)}} {{m_name(date("m",$report->date_start))}} {{date("Y",$report->date_start)}} года по {{date("d",$report->date_end)}} {{m_name(date("m",$report->date_end))}} {{date("Y",$report->date_end)}} года
			@else
				за {{ date("Y",$report->date_start) }} год.
			@endif
		</h3>
		<span class="pos_tr_article_out status st-{{10 + $report->status}}">
        	@if($report->status == 2)
        		<span class="status st_inherit">Статус:</span> Опубликован
        	@elseif($report->status == 1)
        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
        	@elseif($report->status == 0)
        		<span class="status st_inherit">Статус:</span> Не опубликован
        	@else
        		<span class="status st_inherit">Статус:</span> Нет материалов
        	@endif
        </span>
		@if( $report->types->slug == 'countrycatalog' )
		<div class="box_save_article mb30">
			<a href="/report/{{ $report->types->slug }}/addcategory/{{ $report->id }}">
				<button class="butt butt_def butt_click_region">Добавить регион</button>
			</a>
		</div>
		@elseif( $report->types->slug == 'yearly' || $report->types->slug == 'various' || $report->types->slug == 'plannedexhibition' )
			@if($report->types->slug == 'yearly')
			<div class="row justify-content-center">
				<button class="butt butt_def onclick_popup_cat mb30">Добавить раздел</button>
				<a href="/report/{{ $report->types->slug }}/add3/{{$report->id}}">
					<button class="butt butt_def butt_add">Добавить материал</button>
				</a>

			</div>
			@elseif($report->types->slug == 'various' )
				<div class="row justify-content-center">

					<a href="/report/{{ $report->types->slug }}/add3/{{$report->id}}">
						<button class="butt butt_def butt_add">Добавить материал</button>
					</a>

				</div>
			@elseif($report->types->slug == 'plannedexhibition' )
				<div class="row justify-content-center">

					<a href="/report/{{ $report->types->slug }}/add3/{{$report->id}}">
						<button class="butt butt_def butt_add">Добавить выставку</button>
					</a>

				</div>
			@endif
			@if($report->types->slug != 'plannedexhibition')
				@if(!empty($report))

						@if(!empty($report->articles))
							@foreach($report->articles as  $article)
								@if(!isset($article->category) && !isset($article->subcategory) && $article->report_id == $report->id )
								<div class="row padl_sub2 out_list_title">

									<a href="/report/{{ $report->types->slug }}/article/{{ $article->id }}">
										<p>{{ $article->title }}</p>
									</a>

									<form onsubmit="deleteName(this,'{{ $article->title }}');return false;" action="/report/{{ $report->types->slug }}/delete_article/{{ $article->id }}" method="post">
										{{ method_field('delete') }}
										@csrf
										<button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
									</form>

									<a href="/report/{{ $report->types->slug }}/upd/{{$article->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>

									@if($article->status == 0)
										<p class="status st-line st-0">| Не утверждено</p>
									@elseif($article->status == 1)
										<p class="status st-line st-1">| Ожидает утверждения</p>
									@elseif($article->status == 2)
										<p class="status st-line st-2">| Утверждено</p>
									@endif

								</div>
								@endif
							@endforeach
						@endif

				@endif
			@endif
		@endif
		@if( $report->types->slug != 'plannedexhibition' )
        @foreach($categories as $category)
            <div class="row">
                <p class="title">{{ $category->title }}</p>
				@if( $report->types->slug == 'countrycatalog' )
				<form action="/report/{{ $report->types->slug }}/{{ $category->id }}/deleteregion" method="post">
					{{ method_field('delete') }}
					@csrf
					<button class="butt butt_def butt_min butt_add butt_small">Удалить регион</button>
				</form>

				<a href="/report/{{ $report->types->slug }}/upd_category/{{ $category->id }}">
					<button class="butt butt_def butt_min butt_add butt_small">Редактировать регион</button>
				</a>
				@endif
				@if( count($category->subcategories) == 0 )
				<a href="/report/{{ $report->types->slug }}/add3/{{$report->id}}/{{$category->id}}"><button class="butt butt_def butt_min butt_add butt_small">Добавить материал</button></a>
				@endif
				@if( $report->types->slug == 'yearly' )
				<form onsubmit="deleteName(this,'{{ $category->title }}');return false;" action="/report/{{ $report->types->slug }}/{{ $category->id }}/deletecategory" method="post">
					{{ method_field('delete') }}
					@csrf
					<button class="butt butt_def butt_min butt_add butt_small">Удалить раздел</button>
				</form>

				<button class="butt butt_def butt_min butt_add onclick_popup_subcat butt_small" date-cat-id="{{$category->id}}">Добавить подраздел</button>

				<a href="/report/{{ $report->types->slug }}/upd_category/{{$category->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать раздел</button></a>
				@endif
            </div>
			@if( $report->types->slug == 'countrycatalog')
			<div class="row padl_sub2 out_list_title">
				<div class="vpor_box">
					<p class="vpor_title">Военно-политическая обстановка в регионе

					</p>
					<div class="vpor_desc" style="display:none;">
						{!!$category->description !!}
					</div>
				</div>
			</div>
			@endif
			@if( $report->types->slug == 'weekly' || $report->types->slug == 'monthly' || $report->types->slug == 'yearly' || $report->types->slug == 'countrycatalog')
				@foreach( $report->types->categories as  $category )

							@foreach($category->article_reports as $article)
								@if(!isset($article->subcategory))
									@if($article->report_id == $report->id && $article->category_id == $category->id)
										<div class="row padl1 out_list_title">
											<a href="/article/{{ $article->id }}"><p>{{ $article->title }}</p>
											</a>

											<form onsubmit="deleteName(this,'{{ $article->title }}');return false;" action="/report/{{ $report->types->slug }}/delete_article/{{$article->id}}" method="post">
												{{ method_field('delete') }}
												@csrf
												<button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
											</form>


											<a href="/report/{{ $report->types->slug }}/upd/{{$article->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>

											@if($article->status == 0)
												<p class="status st-line st-0">| Не утверждено</p>
											@elseif($article->status == 1)
												<p class="status st-line st-1">| Ожидает утверждения</p>
											@elseif($article->status == 2)
												<p class="status st-line st-2">| Утверждено</p>
											@endif
										</div>
									@endif
								@endif
							@endforeach

							@endforeach

					@endif
					@if(!empty($category->subcategories))
						@foreach($category->subcategories as  $subcategory)
							<div class="row padl_sub1 out_list_title">

								<p class="title">{{ $subcategory->title }}</p>
								@if( $report->types->slug != 'monthly' )
								<form onsubmit="deleteName(this,'{{ $subcategory->title }}');return false;" action="/report/{{ $report->types->slug }}/deletesubcategory/{{ $subcategory->id }}" method="post">
									{{ method_field('delete') }}
									@csrf
									<button  class="butt butt_def butt_min butt_add butt_small">Удалить подраздел</button>
								</form>
								@endif
								<a href="/report/{{ $report->types->slug }}/add3/{{$report->id}}/{{$category->id}}/{{ $subcategory->id }}">
									<button class="butt butt_def butt_min butt_add butt_small">Добавить материал</button>
								</a>
								@if( $report->types->slug != 'monthly' )
								<a href="/report/{{ $report->types->slug }}/upd_subcategory/{{$subcategory->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать подраздел</button></a>
								@endif
									@if(!empty($subcategory->article_reports))
									@foreach($subcategory->article_reports as  $article)
										@if($article->subcategory && $article->report_id == $report->id)
										<div class="row padl_sub2 out_list_title">

											<a href="/report/{{ $report->types->slug }}/article/{{ $article->id }}">
												<p>{{ $article->title }}</p>
											</a>

											<form onsubmit="deleteName(this,'{{ $article->title }}');return false;" action="/report/{{ $report->types->slug }}/{{ $article->id }}/deletearticle" method="post">
												{{ method_field('delete') }}
												@csrf
												<button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
											</form>

											<a href="/report/{{ $report->types->slug }}/upd/{{ $article->id }}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>

											@if($article->status == 0)
												<p class="status st-line st-0">| Не утверждено</p>
											@elseif($article->status == 1)
												<p class="status st-line st-1">| Ожидает утверждения</p>
											@elseif($article->status == 2)
												<p class="status st-line st-2">| Утверждено</p>
											@endif

										</div>
										@endif
									@endforeach
								@endif
							</div>
						@endforeach
					@endif
				@endforeach
		   @elseif ( $report->types->slug == 'plannedexhibition' )
				<div class="col-md-12 out_table analyst_report">
					<table style="border: 1px solid">
						<thead>
						<tr style="border: 1px solid">
							<td style="width: 3%;">
								№ n/n
							</td>
							<td style="width: 35%;">Название</td>
							<td style="width: 15%;">Статус</td>
							<td style="width: 10%;">Редактировать</td>
							<td style="width: 10%;">Удалить</td>
							<td style="width: 17%;">Утвердить</td>
							<td style="width: 10%;">Скачать материалы к выставке</td>
						</tr>
						</thead>
						@foreach($report->articles as $item)
							<tr>
								<td>
									{{ ++$loop->index }}
								</td>
								<td>
									<a style="font-family: 'SegoeUI'" href="/report/{{ $report->types->slug }}/article/{{ $item['id']}}"><?php echo strip_tags
										($item->title, "<p><a><h1><h2><h3><h4><h5><h6>");?> ({{ date("d
										.m",$item->date_start)
										}} -	{{ date
										("d.m
										 Y",
										$item->date_end) }}) </a>
								</td>
								<td>
									@if($item->status != 2)
										Не опубликован
									@else
										Опубликован
									@endif
								</td>
								<td>
									<a class="text_decor" href="/report/{{ $report->types->slug }}/upd/{{ $item->id }}">Редактировать</a>
								</td>
								<td>
									<form onsubmit="deleteName(this,'{{ $report->types->title }} ( {{ date("d.m.Y",$item->date_start) }} - {{ date("d.m.Y",$item->date_end) }} )');return false;" action="/report/{{ $report->types->slug }}/delete_article/{{ $item->id }}" method="post">
										{{ method_field('delete') }}
										@csrf
										<button class="text_decor link">Удалить</button>
									</form>
								</td>
								<td>
									@if($item->status != 2)
										<form action="/report/{{ $report->types->slug }}/article_publish/{{ $item->id }}" method="post">
											{{ method_field('put') }}
											@csrf
											<button class="text_decor red no-btn">Утвердить</button>
										</form>
										{{--<a class="text_decor red" href="/analyst/plannedexhibition/upd/{{ $item['id'] }}">Утвердить</a>--}}
									@else
										Опубликован
									@endif
								</td>
								<td style="text-align: center;">
									<div class="file_wrap">
										@if(isset($item->images))
											@foreach($item->images as $image)
												<a target="_blank" href="/images/{{$image->image}}" class="file_img exhibition"></a>
										@endforeach
									@endif
									<!--a class="text_decor" href="/analyst/plannedexhibition/article/{{ $item['id']}}">Просмотреть</a-->
									</div>
								</td>


							</tr>
						@endforeach
						<tbody>
						</tbody>
					</table>

				</div>
				</div>


			@endif


    <div class="box_save_article">
          
        @if(Request::url() == URL::previous())
		    <a href="/" class="button butt_back">Все отчеты</a>
		@else
			<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
		@endif
			
        @if($report->status == 1)
     
        	<form onsubmit="publishName(this,'{{$report->types->title}}');return false;" action="/report/{{ $report->types->slug }}/publish/{{ $report->id }}" method="post">
                {{ method_field('put') }}
                @csrf
                <button class="butt butt_def">Опубликовать</button>
            </form>
        	
        @endif
    @if($report->status != 2 && $report->status != -1)

        	<form onsubmit="publishName(this,'{{$report->types->title}}');return false;" action="/report/{{ $report->types->slug }}/publish/{{ $report->id }}" method="post">
                {{ method_field('put') }}
                @csrf
                <button class="butt butt_def">Утвердить все материалы и опубликовать</button>
            </form>

        @endif
    </div>

	<!-- modalka cat -->
	<div class="popup popup_cat" style="display: none;">
		<div class="bg_popup bg_popup_cat"></div>
		<form action="/report/{{ $report->types->slug }}/addcategory" method="POST" class="popup_form">
			@csrf
			<input type="text" hidden name="report" value="{{ $report->id }}">
			<input type="text" hidden name="year" value="<?php date('Y', $report->date_end)?>">
			<input type="text" hidden name="month" value="<?php date('m', $report->date_end)?>">
			<div class="close_pop close_popup_cat">x</div>

			<h4 class="mb30">Добавить <span>раздел</span></h4>
			<div class="popup_form_box mb30">
				<input name="title" placeholder="Введите название раздела"/>
			</div>
			<a class="butt_save butt_add_region" href="#">
				<button>Сохранить</button>
			</a>
		</form>
	</div>

	<!-- modalka subcat -->
	<div class="popup popup_subcat" style="display: none;">
		<div class="bg_popup bg_popup_subcat"></div>

		<form action="/report/{{ $report->types->slug }}/addsubcategory" method="POST" class="popup_form">
			@csrf
			<input type="text" hidden name="report" value="{{ $report->id }}">
			<input type="text" hidden name="category" value="2">
			<input type="text" hidden name="year" value="<?php date('Y', $report->date_end)?>">
			<input type="text" hidden name="month" value="<?php date('m', $report->date_end)?>">
			<div class="close_pop close_popup_subcat">x</div>

			<h4 class="mb30">Добавить <span>подраздел</span></h4>
			<div class="popup_form_box mb30">
				<input name="title" placeholder="Введите название подраздела"/>
			</div>
			<a class="butt_save butt_add_region" href="#">
				<button>Сохранить</button>
			</a>
		</form>

	</div>
@endsection
@section('scripts')
	<script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function () {
            jQuery('.vpor_title').on('click', function () {

                if (jQuery(this).parent('.vpor_box').hasClass('active')) {
                    jQuery(this).parent('.vpor_box').removeClass('active');
                    jQuery('.vpor_box .vpor_desc').fadeOut(500);
                } else {
                    jQuery(this).parent('.vpor_box').addClass('active');
                    jQuery('.vpor_box.active .vpor_desc').fadeIn(500);
                }

            })
        })
	</script>
@endsection