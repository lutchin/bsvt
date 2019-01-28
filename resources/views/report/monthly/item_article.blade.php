<?php $role = Auth::user()->roles[0]->title;?>
<?php
function mnames($m) {
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
?>
@extends('layouts.app')

@section('content')
    <div class="container">
         <div class="row d-flex align-items-start article_box">
            <div class="col_270 pr16 border_r1 fll">
                <p><strong>Тип отчета: </strong><span class="italic_14">{{ $reporttitle }}</span></p>
                <p><strong>Период: </strong><span class="italic_14">{{ mnames($arr['article']->month) }} {{ $arr['article']->year }}</span></p>
                <p><strong>Страны: </strong><span class="italic_14">@if(isset($arr['article']->countries))
                        @foreach($arr['article']->countries as $country )
                            {{ $country->title }},
                        @endforeach
                    @endif
                    </span></p>
                <p><strong>Тип ВВТ: </strong><span class="italic_14">@if(isset($arr['article']->vvttypes))
                        @foreach($arr['article']->vvttypes as $type )
                            {{ $type->title }},
                        @endforeach
                    @endif
                    </span>
                </p>
                <p><strong>Компании: </strong><span class="italic_14">@if(isset($arr['article']->companies))
                        @foreach($arr['article']->companies as $item )
                            {{ $item->title }},
                        @endforeach
                    @endif
                    </span>
                </p>
                <p><strong>Персоналии: </strong><span class="italic_14">@if(isset($arr['article']->personalities))
                        @foreach($arr['article']->personalities as $item )
                            {{ $item->title }},
                        @endforeach
                    @endif</span></p>
            </div>
            <div class="col_calc_270 pl30 posr">
				@if( $role != 'user' && $role !='employee' )
            	<span class="pos_tr_article_out status st-{{$arr['article']->published}}">
                	@if($arr['article']->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($arr['article']->published == 1)
                		<span class="status st_inherit">Статус:</span> Ожидает утверждения
                	@elseif($arr['article']->published == 2)
                		<span class="status st_inherit">Статус:</span> Утвержден
                	@else 
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@endif
                </span>
				@endif
            	<a target="_blank" href="/monthly/pdf_article/{{ $arr['article']->id }}" class="pdf pos_tr_article_out"></a>
                @if(isset($arr['article']->title))
                    <h3 class="title padlr30">{{ $arr['article']->title }}</h3>
                @endif

                <p><strong>Отчет: </strong> <span class="italic_14"><a href="/analyst/monthly/show/{{ $arr['article']->monthlyreport_id }}">{{ $reporttitle }}</a></span></p>
                <p class=""><strong>Раздел: </strong> <span class="italic_14">@if(isset($arr['category'])){{$arr['category'] }} @endif</span></p>

                @if(isset($arr['subcategory']))
                    <p class="mb30"><strong>Подраздел: </strong> <span class="italic_14">{{ $arr['subcategory'] }}</span></p>
                @endif
                <div class="content_text">{!! $arr['article']->body !!}</div>
                <div class="gallery_img_content mb30">
                @if(isset($arr['article']->monthlyimages))
                    @foreach($arr['article']->monthlyimages as $image)
                    	<a data-fancybox="gallery" href="/images/{{$image->image}}"><img height="200" src="/images/{{$image->image}}"></a>
                    @endforeach
                @endif
                </div>
            </div>
            
        </div>

        <div class="row box_save_article mt30">
        	
        	@if(Request::url() == URL::previous())
			    <a href="/analyst/monthly/show/{{ $arr['article']->monthlyreport_id}}" class="button butt_back">Вернуться к отчету</a>
			@else
				<a onclick="(function(){window.history.back()})()" class="button butt_back back-button">Назад</a>
			@endif

				@if( $role != 'user' && $role != 'employee' )
					@if($arr['article']->published == 0)
						<form onsubmit="addApprove(this,'{{$reporttitle}}');return false;" action="/analyst/monthly/article_for_approval/{{ $arr['article']->id }}" method="post">
							{{ method_field('put') }}
							@csrf
							<button class="butt butt_def">Отправить на утверждение</button>
						</form>

					@elseif($arr['article']->published == 1)
						<form onsubmit="approve(this,'{{$reporttitle}}');return false;" action="/analyst/monthly/article_publish/{{ $arr['article']->id }}" method="post">
							{{ method_field('put') }}
							@csrf
							<button class="butt butt_def">Утвердить</button>
						</form>
					@endif
				<a class="text_decor" href="/analyst/monthly/upd/{{ $arr['article']->id }}">
					<button class="butt butt_def">Редактировать</button>
				</a>
				@endif
        </div>
        
    </div>
@endsection
