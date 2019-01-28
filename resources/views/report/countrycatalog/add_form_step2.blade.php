<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')
    <div class="container add_form_step2 posr">
        <h3 class="title">"{{ $reporttitle }}" за {{date("Y",$countrycatalog->start_date)}} год</h3>
		
		<span class="pos_tr_article_out status st-{{10 + $countrycatalog->published}}">
        	@if($countrycatalog->published == 2)
        		<span class="status st_inherit">Статус:</span> Опубликован
        	@elseif($countrycatalog->published == 1)
        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
        	@elseif($countrycatalog->published == 0)
        		<span class="status st_inherit">Статус:</span> Не опубликован
        	@else
        		<span class="status st_inherit">Статус:</span> Нет материалов
        	@endif
        </span>
	            
        <div class="box_save_article mb30">
            <a href="/analyst/countrycatalog/addregion/{{ $countrycatalog->id }}">
                <button class="butt butt_def butt_click_region">Добавить регион</button>
            </a>
        </div>

        @if(!empty($items))
            @foreach($items as  $region)
                <div class="row out_list_title">
                    <p class="title">
                    	
                        {{ $region->title }}
                        
                        <form action="/analyst/countrycatalog/{{ $region->id }}/deleteregion" method="post">
	                        {{ method_field('delete') }}
	                        @csrf
	                        <button class="butt butt_def butt_min butt_add butt_small">Удалить регион</button>
	                    </form>
	                    
                        <a href="/analyst/countrycatalog/updregion/{{ $region->id }}/{{ $countrycatalog->id }}">
                            <button class="butt butt_def butt_min butt_add butt_small">Редактировать регион</button>
                        </a>
                        
                        <a href="/analyst/countrycatalog/add3/{{$region->id}}/{{$countrycatalog->id}}">
                            <button class="butt butt_def butt_add butt_min butt_small">Добавить материал</button>
                        </a>
                    	
                    </p>
                </div>
                @if(!empty($region->countries))
                    <div class="row padl_sub2 out_list_title">
                        <div class="vpor_box">
                            <p class="vpor_title">Военно-политическая обстановка в регионе
	                            @if($region->published == 0)
	                        		<span class="status st-line st-0">| Не утверждено</span>
	                        	@elseif($region->published == 1)
	                        		<span class="status st-line st-1">| Ожидает утверждения</span>
	                        	@elseif($region->published == 2)
	                        		<span class="status st-line st-2">| Утверждено</span>
	                        	@endif	
                            </p>
                            
                            <div class="vpor_desc" style="display:none;">
                                {!!$region->overview !!}
                            </div>
                        </div>
                    </div>
                    @foreach($region->countries as  $country)

                        <div class="row padl_sub1 out_list_title">
                            <a href="/analyst/countrycatalog/article/{{ $country->id }}/{{ $countrycatalog->id }}">
                                <p>{{ $country->title }}</p>
                            </a>

                            <form action="/analyst/countrycatalog/{{ $country->id }}/deletearticle" method="post">
                                {{ method_field('delete') }}
                                @csrf
                                <button class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
                            </form>


                            <a href="/analyst/countrycatalog/upd/{{$country->id}}/{{ $countrycatalog->id }}">
                                <button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button>
                            </a>
                            
                            @if($country->published == 0)
                        		<p class="status st-line st-0">| Не утверждено</p>
                        	@elseif($country->published == 1)
                        		<p class="status st-line st-1">| Ожидает утверждения</p>
                        	@elseif($country->published == 2)
                        		<p class="status st-line st-2">| Утверждено</p>
                        	@endif
                        </div>

                    @endforeach
                @endif
            @endforeach
        @endif


    </div>

    <div class="box_save_article mt10">
          
        @if(Request::url() == URL::previous())
		    <a href="/analyst/countrycatalog/" class="button butt_back">Все отчеты</a>
		@else
			<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
		@endif


        @if($countrycatalog->published == 1)
     
        	<form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/countrycatalog/publish/{{ $countrycatalog->id }}" method="post">
                {{ method_field('put') }}
                @csrf
                <button class="butt butt_def">Опубликовать</button>
            </form>
        	
        @endif
        @if($countrycatalog->published != 2)

                <form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/countrycatalog/publish/{{ $countrycatalog->id }}" method="post">
                    {{ method_field('put') }}
                    @csrf
                    <button class="butt butt_def">Утвердить все материалы и опубликовать</button>
                </form>

            @endif
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
