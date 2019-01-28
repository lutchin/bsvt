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
    	
        <h3 class="title">Еженедельный дайжест "{{ $reporttitle }}" № {{ $weeklyreport->number }} за период от {{date("d",$weeklyreport->start_date)}} {{m_name($month)}} {{date("Y",$weeklyreport->start_date)}} года по {{date("d",$weeklyreport->end_date)}} {{m_name($month)}} {{date("Y",$weeklyreport->end_date)}} года</h3>
		
		<span class="pos_tr_article_out status st-{{10 + $weeklyreport->published}}">
        	@if($weeklyreport->published == 2)
        		<span class="status st_inherit">Статус:</span> Опубликован
        	@elseif($weeklyreport->published == 1)
        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
        	@elseif($weeklyreport->published == 0)
        		<span class="status st_inherit">Статус:</span> Не опубликован
        	@else
        		<span class="status st_inherit">Статус:</span> Нет материалов
        	@endif
        </span>
	            
        @foreach($categories as $category)
            <div class="row">
                <p class="title">{{ $category->title }}</p>
				
                <a href="/analyst/weekly/add3/{{$category->id}}/{{$weeklyreport->id}}"><button class="butt butt_def butt_min butt_add butt_small">Добавить материал</button></a>
            	
            </div>
            @if(!empty($items))
                @foreach($items as  $cat =>$posts)
                    @if(isset($posts))
                        @foreach($posts as  $post)
                            @if($cat == $category->title)
                                <div class="row padl1 out_list_title">
                                    <a href="/analyst/weekly/article/{{ $post->id }}"><p>{{ $post->title }}</p>
                                    </a>
                                    
									<form onsubmit="deleteName(this,'{{ $post->title }}');return false;" action="/analyst/weekly/{{$post->id}}/deletearticle" method="post">
										{{ method_field('delete') }}
										@csrf
										<button  class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
									</form>
									
									
                                    <a href="/analyst/weekly/upd/{{$post->id}}"><button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button></a>
                                	
                                	@if($post->published == 0)
                                		<p class="status st-line st-0">| Не утверждено</p>
                                	@elseif($post->published == 1)
                                		<p class="status st-line st-1">| Ожидает утверждения</p>
                                	@elseif($post->published == 2)
                                		<p class="status st-line st-2">| Утверждено</p>
                                	@endif
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>

    <div class="box_save_article">
          
        @if(Request::url() == URL::previous())
		    <a href="/analyst/weekly/" class="button butt_back">Все отчеты</a>
		@else
			<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
		@endif
			
        @if($weeklyreport->published == 1)
     
        	<form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/weekly/publish/{{ $weeklyreport['id'] }}" method="post">
                {{ method_field('put') }}
                @csrf
                <button class="butt butt_def">Опубликовать</button>
            </form>
        	
        @endif
    @if($weeklyreport->published != 2)

        	<form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/weekly/publish/{{ $weeklyreport['id'] }}" method="post">
                {{ method_field('put') }}
                @csrf
                <button class="butt butt_def">Утвердить все материалы и опубликовать</button>
            </form>

        @endif
    </div>
@endsection
