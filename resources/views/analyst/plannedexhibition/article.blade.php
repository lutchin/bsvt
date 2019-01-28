<?php $role = Auth::user()->roles[0]->title; ?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex align-items-start article_box">
            <div class="col_270 pr16 border_r1 fll">
                <p><strong>Тип отчета: </strong><span class="italic_14">{{ $reporttitle }}</span></p>
                <p><strong>Период: </strong>
                    <span class="italic_14">{{ date("d.m.Y",$plannedexhibition->start) }}
                        - {{ date("d.m.Y",$plannedexhibition->fin) }}</span></p>

                <p><strong>Страны: </strong>
                    <span class="italic_14">
                        @if(isset($plannedexhibition->countries))
                            @foreach($plannedexhibition->countries as $country )
                                {{ $country->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

                <p><strong>Тип ВВТ: </strong> <span class="italic_14"> @if(isset($plannedexhibition->vvttypes))
                            @foreach($plannedexhibition->vvttypes as $type )
                                {{ $type->title }},
                            @endforeach
                        @endif
                   </span>
                </p>

                <p><strong>Компании: </strong> <span class="italic_14"> @if(isset($plannedexhibition->companies))
                            @foreach($plannedexhibition->companies as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

                <p><strong>Персоналии: </strong> <span class="italic_14"> @if(isset($plannedexhibition->personalities))
                            @foreach($plannedexhibition->personalities as $item )
                                {{ $item->title }},
                            @endforeach
                        @endif
                    </span>
                </p>

            </div>
            <div class="col_calc_270 pl30 posr">
                @if( $role != 'user' && $role !='employee' )
                    <span class="pos_tr_article_out status st-{{$plannedexhibition->published}}">
            	@if($plannedexhibition->published == 0)
                            <span class="status st_inherit">Статус:</span> Не утвержден
                        @elseif($plannedexhibition->published == 1)
                            <span class="status st_inherit">Статус:</span> Ожидает утверждения
                        @else
                            <span class="status st_inherit">Статус:</span> Утвержден
                        @endif
                </span>
                @endif
                {{--@if(Auth::user() && Auth::user()->isemployee())--}}
                {{--<a target="_blank" href="/plannedexhibition/pdf_article/{{ $plannedexhibition->id }}" class="pdf pos_tr_article_out"></a>--}}
                {{--@endif--}}

                <div class="article_title">
                    @if(isset($plannedexhibition->title))
                        <?php echo strip_tags
                        ($plannedexhibition->title, "<p><a><h1><h2><h3><h4><h5><h6><b>");
                        ?>
                    @endif
                </div>
                <p><strong>Отчет: </strong>
                    <span class="italic_14"><a href="{{ URL::previous() }}">{{ $reporttitle }}</a></span></p>
                {{--<p class="mb10 w100 fll"><strong>Регион:&nbsp</strong>--}}
                {{--<span class="italic_14">{!! strip_tags($plannedexhibition->region) !!}</span>--}}
                {{--</p>--}}
                {{--<p class="mb10 w100 fll"><strong>Страна:&nbsp</strong>--}}
                {{--<span class="italic_14">{!! strip_tags($plannedexhibition->country) !!}</span>--}}
                {{--</p>--}}
                <p class="mb10 w100 fll"><strong>Место:&nbsp</strong>
                    <span class="italic_14">{!! strip_tags($plannedexhibition->place) !!}</span>
                </p>
                <p class="mb10 w100 fll"><strong>Тематика:&nbsp</strong>
                    <span class="italic_14">{!! strip_tags($plannedexhibition->theme) !!}</span>
                </p>

                <div class="content_text">{!!   $plannedexhibition->description !!}</div>
                <div class="mb10">
                  @if(isset($plannedexhibition->images))
                  <strong>Скачать материалы:&nbsp</strong>
                    @foreach($plannedexhibition->images as $image)
                      <a target="_blank" href="/images/{{$image->image}}" class="file_img file_img--article exhibition"></a>
                    @endforeach
                  @endif
                </div>
            </div>
        </div>
        <div class="row box_save_article mt30">
            @if(Request::url() == URL::previous())
                <a href="/analyst/plannedexhibition/show/{{ $plannedexhibition->plannedexhibitionyear_id}}"
                   class="button butt_back">Вернуться к отчету
                </a>
            @else
                <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
            @endif

            @if( $role != 'user' && $role !='employee' )
                @if($plannedexhibition->published == 0)
                    <form onsubmit="addApprove(this,'{{$reporttitle}}');return false;"
                          action="/analyst/plannedexhibition/article_for_approval/{{ $plannedexhibition->id }}"
                          method="post">
                        {{ method_field('put') }}
                        @csrf
                        <button class="butt butt_def">Отправить на утверждение</button>
                    </form>
                @elseif($plannedexhibition->published == 1)
                    <form onsubmit="approve(this,'{{$reporttitle}}');return false;"
                          action="/analyst/plannedexhibition/article_publish/{{ $plannedexhibition->id }}"
                          method="post">
                        {{ method_field('put') }}
                        @csrf
                        <button class="butt butt_def">Утвердить</button>
                    </form>
                @endif

                <a class="text_decor" href="/analyst/plannedexhibition/upd/{{ $plannedexhibition->id }}">
                    <button class="butt butt_def">Редактировать</button>
                </a>
            @endif
        </div>

    </div>
@endsection
