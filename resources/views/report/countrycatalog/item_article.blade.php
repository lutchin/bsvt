<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-start article_box">
            <div class="col_270 pr16 border_r1 fll">
                <p><strong>Тип отчета: </strong><span class="italic_14">{{ $reporttitle }}</span></p>
                <p><strong>Период: </strong>
                    <span class="italic_14">c {{date("d.m.Y",$infocountry->start_date)}} до {{date("d.m.Y",$infocountry->end_date)}}</span></p>
                <p><strong>Страны: </strong> <span class="italic_14">
                        @if(isset($infocountry->countries))
                            @foreach($infocountry->countries as $country )
                                {{ $country->title }},
                            @endforeach
                        @endif
                    </span></p>

                <p><strong>Тип ВВТ: </strong> <span class="italic_14"> @if(isset($infocountry->vvttypes))
                            @foreach($infocountry->vvttypes as $type )
                                {{ $type->title }},
                            @endforeach
                        @endif
                   </span>
                </p>

                <p><strong>Компании: </strong> <span class="italic_14"> @if(isset($infocountry->companies))
                            @foreach($infocountry->companies as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

                <p><strong>Персоналии: </strong> <span class="italic_14"> @if(isset($infocountry->personalities))
                            @foreach($infocountry->personalities as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

            </div>
            <div class="col_calc_270 pl30 posr">
                <a target="_blank" href="/countrycatalog/pdf_article/{{ $infocountry->id }}" class="pdf pos_tr_article_out"></a>
                @if(isset($infocountry->title))
                    <h3 class="title padlr30">{{ $infocountry->title }}</h3>
                    @if( $role != 'user' && $role !='employee' )
                    <span class="pos_tr_article_out status st-{{10 + $infocountry->published}}">
			        	@if($infocountry->published == 2)
			        		<span class="status st_inherit">Статус:</span> Утвержден
			        	@elseif($infocountry->published == 1)
			        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
			        	@elseif($infocountry->published == 0)
			        		<span class="status st_inherit">Статус:</span> Не утвержден
			        		
			        	@endif
			        </span>
                    @endif
                @endif
                <p><strong>Отчет: </strong> <span class="italic_14"><a href="/countrycatalog/show/{{ $countrycatalog_id }}">{{ $reporttitle }}</a></span></p>
                <p class="mb30"><strong>Раздел: </strong>
                    <span class="italic_14">{{$infocountry->region->title }}</span></p>

                <div class="content_text">{!!   $infocountry->overview !!}</div>
                <div class="gallery_img_content mb30">
                    @if(isset($infocountry->images))
                        @foreach($infocountry->images as $image)
                            <a data-fancybox="gallery" href="/images/{{$image->image}}"><img height="200" src="/images/{{$image->image}}"></a>
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
        
        <div class="row box_save_article mt30">
        	
        	@if(Request::url() == URL::previous())
			    <a href="/analyst/countrycatalog/show/{{ $countrycatalog_id }}" class="button butt_back">Вернуться к отчету</a>
			@else
				<a onclick="(function(){window.history.back()})()" class="button butt_back back-button">Назад</a>
			@endif

                @if( $role != 'user' && $role !='employee' )
                        @if($infocountry->published == 0)
                            <form onsubmit="addApprove(this,'{{$reporttitle}}');return false;" action="/analyst/countrycatalog/article_for_approval/{{ $infocountry->id }}" method="post">
                                {{ method_field('put') }}
                                @csrf
                                <button class="butt butt_def">Отправить на утверждение</button>
                            </form>
                        @elseif($infocountry->published == 1)
                            <form onsubmit="approve(this,'{{$reporttitle}}');return false;" action="/analyst/countrycatalog/article_publish/{{ $infocountry->id }} " method="post">
                                {{ method_field('put') }}
                                @csrf
                                <button class="butt butt_def">Утвердить</button>
                            </form>
                        @endif

                        <a class="text_decor" href="/analyst/countrycatalog/upd/{{ $infocountry->id }}/{{ $countrycatalog_id }}">
                            <button class="butt butt_def">Редактировать</button>
                        </a>
                @endif
        </div>

    </div>
@endsection
