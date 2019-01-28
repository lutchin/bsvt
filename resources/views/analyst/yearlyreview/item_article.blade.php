<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-start article_box">
            <div class="col_270 pr16 border_r1 fll">
                <p><strong>Тип отчета: </strong><span class="italic_14">{{ $reporttitle }}</span></p>
                <p><strong>Период: </strong>
                    <span class="italic_14">с {{ date("d.m.Y",$article->start_period) }} до {{ date("d.m.Y",$article->end_period) }}</span>
                </p>
                <p><strong>Страны: </strong>
                    <span class="italic_14">
                        @if(isset($article->countries))
                            @foreach($article->countries as $country )
                                {{ $country->title }},
                            @endforeach
                        @endif
                    </span></p>

                <p><strong>Тип ВВТ: </strong> <span class="italic_14"> @if(isset($article->vvttypes))
                            @foreach($article->vvttypes as $type )
                                {{ $type->title }},
                            @endforeach
                        @endif
                   </span>
                </p>

                <p><strong>Компании: </strong> <span class="italic_14"> @if(isset($article->companies))
                            @foreach($article->companies as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

                <p><strong>Персоналии: </strong> <span class="italic_14"> @if(isset($article->personalities))
                            @foreach($article->personalities as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

            </div>
            <div class="col_calc_270 pl30 posr">
                <a target="_blank" href="/yearly/pdf_article/{{ $article->id }}" class="pdf pos_tr_article_out"></a>
                <h3 class="title padlr30">{{$article->title }}</h3>
                @if( $role != 'user' && $role !='employee' )
                <span class="pos_tr_article_out status st-{{$article->published}}">
                	@if($article->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($article->published == 1)
                		<span class="status st_inherit">Статус:</span> Ожидает утверждения
                	@else
                		<span class="status st_inherit">Статус:</span> Утвержден
                	@endif
                </span>
                @endif
                <p><strong>Отчет: </strong>
                    <span class="italic_14"><a href="{{ URL::previous() }}">{{ $reporttitle }}</a></span></p>

                    @if(isset($article->subcategory))
                    <p class="mb30"><strong>Раздел: </strong>
                        <span class="italic_14">{{ $article->subcategory->category->title }}</span>
                    @elseif (isset($article->category))
                    <p class="mb30"><strong>Раздел: </strong>
                        <span class="italic_14">{{ $article->category->title }}</span>
                    @endif
                </p>
                @if(isset($article->subcategory->title))
                    <p class="mb30"><strong>Подраздел: </strong>
                        <span class="italic_14">{{ $article->subcategory->title }}</span></p>
                @endif
                <div class="content_text">{!! $article->body !!} </div>
                <div class="gallery_img_content mb30">
                    @if(isset($article->images))
                        @foreach($article->images as $image)
                            <a data-fancybox="gallery" href="/images/{{$image->image}}"><img height="200" src="/images/{{$image->image}}"></a>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <div class="row box_save_article mt30">
        	
	        	@if(Request::url() == URL::previous())
				    <a href="/analyst/yearly/show/{{ $yearlyreport->id }}" class="button butt_back">Вернуться к отчету</a>
				@else
					<a onclick="(function(){window.history.back()})()" class="button butt_back">Назад</a>
				@endif

                    @if( $role != 'user' && $role !='employee' )
                        @if($article->published == 0)
                            <form onsubmit="addApprove(this,'{{$reporttitle}}');return false;" action="/analyst/yearly/article_for_approval/{{ $article->id }}" method="post">
                                {{ method_field('put') }}
                                @csrf
                                <button class="butt butt_def">Отправить на утверждение</button>
                            </form>
                        @elseif($article->published == 1)
                            <form onsubmit="approve(this,'{{$reporttitle}}');return false;" action="/analyst/yearly/article_publish/{{ $article->id }}" method="post">
                                {{ method_field('put') }}
                                @csrf
                                <button class="butt butt_def">Утвердить</button>
                            </form>
                        @endif

                        <a class="text_decor" href="/analyst/yearly/upd/{{ $article->id }}">
                            <button class="butt butt_def">Редактировать</button>
                        </a>
                    @endif
	        </div>
            
        </div>
    </div>
@endsection
