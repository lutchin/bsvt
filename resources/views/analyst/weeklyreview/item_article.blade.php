<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-start article_box">
            <div class="col_270 pr16 border_r1 fll">
                <p><strong>Тип отчета: </strong><span class="italic_14">{{ $reporttitle }}</span></p>
                <p><strong>Период: </strong>
                    <span class="italic_14">c {{date("d.m.Y",$arr['article']->start_period)}} по {{date("d.m.Y",$arr['article']->end_period)}}</span>
               </p>
                  
                <p><strong>Страны: </strong><span class="italic_14">@if(isset($arr['article']->countries))
                        @foreach($arr['article']->countries as $country )
                            {{ $country->title }},
                        @endforeach
                    @endif
                    </span>
                </p>
                
                <p><strong>Тип ВВТ: </strong> <span class="italic_14"> @if(isset($arr['article']->vvttypes))
                            @foreach($arr['article']->vvttypes as $type )
                                {{ $type->title }},
                            @endforeach
                        @endif
                   </span>
                </p>

                <p><strong>Компании: </strong> <span class="italic_14"> @if(isset($arr['article']->companies))
                            @foreach($arr['article']->companies as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

                <p><strong>Персоналии: </strong> <span class="italic_14"> @if(isset($arr['article']->personalities))
                            @foreach($arr['article']->personalities as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

            </div>
            <div class="col_calc_270 pl30 posr">
                @if( $role != 'user' && $role !='employee' )
                <span class="pos_tr_article_out status st-{{$arr['article']->published}}">
                	@if($arr['article']->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($arr['article']->published == 1)
                		<span class="status st_inherit">Статус:</span> Ожидает утверждения
                	@else
                		<span class="status st_inherit">Статус:</span> Утвержден
                	@endif
                </span>
                @endif
                @if(isset($arr['article']->title))
                    <h3 class="title padlr30">{{ $arr['article']->title }}</h3>
                @endif
                
                <a target="_blank" href="/weekly/pdf_article/{{ $arr['article']->id }}" class="pdf pos_tr_article_out"></a>
                <p><strong>Отчет: </strong> <span class="italic_14"><a class="text_decor" href="/analyst/weekly/show/{{ $arr['article']->weeklyreport_id }}">{{ $reporttitle }}</a></span></p>
                <p class="mb30"><strong>Раздел: </strong>
                    <span class="italic_14">@if(isset($arr['category'])){{$arr['category'] }} @endif</span></p>
                <div class="content_text">{!!   $arr['article']->body !!}</div>
                <div class="gallery_img_content mb30">
                    @if(isset($arr['article']->weeklyimages))
                        @foreach($arr['article']->weeklyimages as $image)
                            <a data-fancybox="gallery" href="/images/{{$image->image}}"><img height="200" src="/images/{{$image->image}}"></a>
                        @endforeach
                    @endif
                </div>
				
				
            </div>
        </div>
        
        <div class="row box_save_article mt30">
        	
        	@if(Request::url() == URL::previous())
			    <a href="/analyst/weekly/show/{{ $arr['article']->weeklyreport_id}}" class="button butt_back">Вернуться к отчету</a>
			@else
				<a onclick="(function(){window.history.back()})()" class="button butt_back back-button">Назад</a>
			@endif

                @if( $role != 'user' && $role !='employee' )
                    @if($arr['article']->published == 0)
                        <form onsubmit="addApprove(this,'{{$reporttitle}}');return false;" action="/analyst/weekly/article_for_approval/{{ $arr['article']->id }}" method="post">
                            {{ method_field('put') }}
                            @csrf
                            <button class="butt butt_def">Отправить на утверждение</button>
                        </form>
                    @elseif($arr['article']->published == 1)
                        <form onsubmit="approve(this,'{{$reporttitle}}');return false;" action="/analyst/weekly/article_publish/{{ $arr['article']->id }}" method="post">
                            {{ method_field('put') }}
                            @csrf
                            <button class="butt butt_def">Утвердить</button>
                        </form>
                    @endif

                    <a class="text_decor" href="/analyst/weekly/upd/{{ $arr['article']->id }}">
                        <button class="butt butt_def">Редактировать</button>
                    </a>
                @endif
        </div>
        
    </div>
@endsection