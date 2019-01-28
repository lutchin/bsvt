<?php

function m_name ( $m ) {
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
        <h3 class="title">Ежемесячный бюллетень "{{ $reporttitle }}" № {{ $monthlyreport->number }} за период от {{date("d",$monthlyreport->start_date)}} {{m_name(date("m",$monthlyreport->start_date))}} {{date("Y",$monthlyreport->start_date)}} по {{date("d",$monthlyreport->end_date)}} {{m_name(date("m",$monthlyreport->end_date))}} {{date("Y",$monthlyreport->end_date)}}</h3>

        <span class="pos_tr_article_out status st-{{10 + $monthlyreport['published']}}">
        	@if($monthlyreport['published'] == 2)
                <span class="status st_inherit">Статус:</span> Опубликован
            @elseif($monthlyreport['published'] == 1)
                <span class="status st_inherit">Статус:</span> Все материалы утверждены
            @elseif($monthlyreport['published'] == 0)
                <span class="status st_inherit">Статус:</span> Не опубликован
            @else
                <span class="status st_inherit">Статус:</span> Нет материалов
            @endif
        </span>

        @foreach($categories as $category)
            <div class="row out_list_title">
                <p class="title">{{ $category->title }}
                    @if($category->subcategories->count() == 0)
                        <a href="/analyst/monthly/add3/{{$category->id}}/0/{{$monthlyreport->id}}">
                            <button class="butt butt_def butt_add butt_min">Добавить материал</button>
                        </a>
                        @if(!empty($items))
                            @foreach($items as  $cat =>$arr)
                                @if(is_array($arr))
                                    @foreach($arr as  $item)
                                        @foreach($item as $post)
                                            @if( $post->category_id == $category->id)
                                                <div class="row padl1 out_list_title">
                                                    <a href="/analyst/monthly/article/{{ $post->id }}">
                                                        <p>{{ $post->title }}</p>

                                                    </a>
                                                    <form action="/analyst/monthly/{{$post->id}}/deletearticle" method="post">
                                                        {{ method_field('delete') }}
                                                        @csrf
                                                        <button class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
                                                    </form>
                                                    <a href="/analyst/monthly/upd/{{$post->id}}">
                                                        <button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button>
                                                    </a>
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
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                     @endif
                </p>
       </div>
                    @foreach($subcategories as $subcategory)
                        @if($category->id == $subcategory->category_id)

                            <div class="row padl1 out_list_title">
                                <p>{{ $subcategory->title }}</p>
                                <a href="/analyst/monthly/add3/{{$category->id}}/{{$subcategory->id}}/{{$monthlyreport->id}}">
                                    <button class="butt butt_def butt_min butt_add">Добавить материал</button>
                                </a>
                            </div>
                            @if(!empty($items))
                                @foreach($items as  $cat =>$arr)
                                    @if(isset($arr))
                                        @foreach($arr as  $post)
                                            @foreach($post as $subcat =>$art)
                                                @if(isset($art->subcategory_id) and $art->subcategory_id == $subcategory->id)
                                                    <div class="row padl_sub2  out_list_title">
                                                        <a href="/analyst/monthly/article/{{ $art->id }}">
                                                            <p>{{ $art->title }}</p>
                                                        </a>
                                                        <form action="/analyst/monthly/{{$art->id}}/deletearticle" method="post">
                                                            {{ method_field('delete') }}
                                                            @csrf
                                                            <button class="butt butt_def butt_min butt_add butt_small">Удалить материал</button>
                                                        </form>
                                                        <a href="/analyst/monthly/upd/{{$art->id}}">
                                                            <button class="butt butt_def butt_min butt_add butt_small">Редактировать материал</button>
                                                        </a>

                                                        @if($art->published == 0)
                                                            <p class="status st-line st-0">| Не утверждено</p>
                                                        @elseif($art->published == 1)
                                                            <p class="status st-line st-1">| Ожидает утверждения</p>
                                                        @elseif($art->published == 2)
                                                            <p class="status st-line st-2">| Утверждено</p>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                     @endif
                                @endforeach
                            @endif
                        @endif
                    @endforeach
    @endforeach
 </div>

      <div class="box_save_article">

                                        @if(Request::url() == URL::previous())
                                            <a href="/analyst/monthly/" class="button butt_back">Все отчеты</a>
                                        @else
                                            <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                                        @endif

                                        @if($monthlyreport['published'] == 1)

                                            <form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/monthly/publish/{{ $monthlyreport->id }}" method="post">
                                                {{ method_field('put') }}
                                                @csrf
                                                <button class="butt butt_def">Опубликовать</button>
                                            </form>

                                        @endif
                                            @if($monthlyreport['published'] != 2)

                                                <form onsubmit="publishName(this,'{{$reporttitle}}');return false;" action="/analyst/monthly/publish/{{ $monthlyreport->id }}" method="post">
                                                    {{ method_field('put') }}
                                                    @csrf
                                                    <button class="butt butt_def">Утвердить все материалы и опубликовать</button>
                                                </form>

                                            @endif
                                    </div>
@endsection
