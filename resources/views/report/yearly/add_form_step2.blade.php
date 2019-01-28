<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')
<div class="container add_form_step2 posr">
    <h3 class="title">
        "{{ $reporttitle }}"<!--№ {{ $yearlyreport->number }}--> за {{date("Y",$yearlyreport->start_date)}} год</h3>
    
    <span class="pos_tr_article_out status st-{{10 + $yearlyreport->published}}">
    	@if($yearlyreport->published == 2)
    		<span class="status st_inherit">Статус:</span> Опубликован
    	@elseif($yearlyreport->published == 1)
    		<span class="status st_inherit">Статус:</span> Все материалы утверждены
    	@elseif($yearlyreport->published == 0)
    		<span class="status st_inherit">Статус:</span> Не опубликован
    	@else
    		<span class="status st_inherit">Статус:</span> Нет материалов
    	@endif
    </span>
    <div class="row justify-content-center">
      <button class="butt butt_def onclick_popup_cat mb30">Добавить раздел</button>
      <a href="/analyst/yearly/add3/{{$yearlyreport->id}}">
          <button class="butt butt_def butt_add">Добавить материал</button>
      </a>
    </div>
    @if(!empty($items))
        @foreach($items as  $report)
            @if(!empty($report->articlesReport))
                @foreach($report->articlesReport as  $article)
        <div class="row padl_sub2 out_list_title">

            <a href="/analyst/yearly/article/{{ $article->id }}">
                <p>{{ $article->title }}</p>
            </a>

            <form onsubmit="deleteName(this,'{{ $article->title }}');return false;" action="/analyst/yearly/{{ $article->id }}/deletearticle" method="post">
                {{ method_field('delete') }}
                @csrf
                <button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
            </form>

            <a href="/analyst/yearly/upd/{{$article->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>

            @if($article->published == 0)
                <p class="status st-line st-0">| Не утверждено</p>
            @elseif($article->published == 1)
                <p class="status st-line st-1">| Ожидает утверждения</p>
            @elseif($article->published == 2)
                <p class="status st-line st-2">| Утверждено</p>
            @endif

        </div>
                @endforeach
          @endif
            @if(!empty($report->categories))
                @foreach($report->categories as  $category)
                    <div class="row out_list_title mt10">
                    	
                        <p class="title">
                        	{{ $category->title }}                            
                          
                          <form onsubmit="deleteName(this,'{{ $category->title }}');return false;" action="/analyst/yearly/{{ $category->id }}/deletecategory" method="post">                            
                            {{ method_field('delete') }}
                            @csrf
                            <button class="butt butt_def butt_min butt_add butt_small">Удалить раздел</button>
                          </form>

                          <a href="/analyst/yearly/add3/{{$yearlyreport->id}}/{{$category->id}}">
                              <button class="butt butt_def butt_min butt_add butt_small">Добавить материал</button>
                          </a>

                          <button class="butt butt_def butt_min butt_add onclick_popup_subcat butt_small" date-cat-id="{{$category->id}}">Добавить подраздел</button>

                          <a href="/analyst/yearly/upd_category/{{$category->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать раздел</button></a>
                          
                        </p>
                        @if(!empty($category->articles))
                            @foreach($category->articles as  $catarticle)
                                <div class="row padl_sub2 out_list_title">

                                    <a href="/analyst/yearly/article/{{ $catarticle->id }}">
                                        <p>{{ $catarticle->title }}</p>
                                    </a>
                                                              
                                    <form onsubmit="deleteName(this,'{{ $catarticle->title }}');return false;" action="/analyst/yearly/{{ $catarticle->id }}/deletearticle" method="post">
                                      {{ method_field('delete') }}
                                      @csrf
                                      <button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
                                    </form>
									
                                    <a href="/analyst/yearly/upd/{{$catarticle->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>
                                	
                                	@if($catarticle->published == 0)
                                		<p class="status st-line st-0">| Не утверждено</p>
                                	@elseif($catarticle->published == 1)
                                		<p class="status st-line st-1">| Ожидает утверждения</p>
                                	@elseif($catarticle->published == 2)
                                		<p class="status st-line st-2">| Утверждено</p>
                                	@endif
                                	
                                </div>
                            @endforeach
                        @endif
                    </div>
                    @if(!empty($category->subcategories))
                        @foreach($category->subcategories as  $subcategory)
                                <div class="row padl_sub1 out_list_title">

                                    <p>{{ $subcategory->title }}</p>

                                    <form onsubmit="deleteName(this,'{{ $subcategory->title }}');return false;" action="/analyst/yearly/{{ $subcategory->id }}/deletesubcategory" method="post">
                                      {{ method_field('delete') }}
                                      @csrf
                                      <button  class="butt butt_def butt_min butt_add butt_small">Удалить подраздел</button>
                                    </form>

                                    <a href="/analyst/yearly/add3/{{$yearlyreport->id}}/{{$category->id}}/{{ $subcategory->id }}">
                                        <button class="butt butt_def butt_min butt_add butt_small">Добавить материал</button>
                                    </a>

                                    <a href="/analyst/yearly/upd_subcategory/{{$subcategory->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать подраздел</button></a>
                                    @if(!empty($subcategory->articles))
                                        @foreach($subcategory->articles as  $article)
                                            <div class="row padl_sub2 out_list_title">

                                                <a href="/analyst/yearly/article/{{ $article->id }}">
                                                    <p>{{ $article->title }}</p>
                                                </a>
                                                
                                                <form onsubmit="deleteName(this,'{{ $article->title }}');return false;" action="/analyst/yearly/{{ $article->id }}/deletearticle" method="post">
													{{ method_field('delete') }}
													@csrf
													<button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
												</form>
									
                                				<a href="/analyst/yearly/upd/{{ $article->id }}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>
                                            
                                            	@if($article->published == 0)
			                                		<p class="status st-line st-0">| Не утверждено</p>
			                                	@elseif($article->published == 1)
			                                		<p class="status st-line st-1">| Ожидает утверждения</p>
			                                	@elseif($article->published == 2)
			                                		<p class="status st-line st-2">| Утверждено</p>
			                                	@endif
			                                	
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        @endif
    </div>
   <div class="box_save_article mt30">
      
    @if(Request::url() == URL::previous())
	    <a href="/analyst/yearly/" class="button butt_back">Все отчеты</a>
	@else
		<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
	@endif
		
    @if($yearlyreport->published == 1)
 
    	<form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/yearly/publish/{{ $yearlyreport['id'] }}" method="post">
            {{ method_field('put') }}
            @csrf
            <button class="butt butt_def">Опубликовать</button>
        </form>
    	
    @endif
@if($yearlyreport->published != 2)

    	<form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/yearly/publish/{{ $yearlyreport['id'] }}" method="post">
            {{ method_field('put') }}
            @csrf
            <button class="butt butt_def">Утвердить все материалы и опубликовать</button>
        </form>

    @endif
</div>

        <!-- modalka cat -->
        <div class="popup popup_cat" style="display: none;">
            <div class="bg_popup bg_popup_cat"></div>
            <form action="/analyst/yearly/createcategory" method="POST" class="popup_form">
                @csrf
                <input type="text" hidden name="yearlyreport" value="{{ $yearlyreport->id }}">
                <input type="text" hidden name="year" value="<?= $y?>">
                <input type="text" hidden name="month" value="<?= $m?>">
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
            
            <form action="/analyst/yearly/createsubcategory" method="POST" class="popup_form">
                @csrf
                <input type="text" hidden name="yearlyreport" value="{{ $yearlyreport->id }}">
                <input type="text" hidden name="yearlycategory" value="2">
                <input type="text" hidden name="year" value="<?= $y?>">
                <input type="text" hidden name="month" value="<?= $m?>">
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
