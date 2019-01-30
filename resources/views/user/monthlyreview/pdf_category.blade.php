<?php

function getMonthText($m) {
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
@extends('layouts.pdf')

@section('content')
    {{--<p>--}}
        {{--Тип отчета: {{ $reporttitle }}--}}
    {{--</p>--}}

    <h3 class="title" style="text-align: center">{{ $report->types->description}} ({{ getMonthText(date('m', $report->date_start)) }} {{ date('Y', $report->date_start) }})</h3>

                <p class="title title_cat" style="text-align: center">
                    {{--{{ $n1 }}.--}} <strong>{{ $category->title }}</strong>
                </p>


            @foreach($report_array as  $sub_cat =>$posts)
                @if($sub_cat !== 'false')
                    <?php /*$n2++; */?>
                    <!-- <div class="row"> -->
                        <h3 class="title padl_sub1 title_sub_cat" style="text-align: center">
                            {{--{{ $n1 }}.{{ $n2 }}. --}}<strong>{{ $sub_cat  }}</strong>
                        </h3>
                    <!-- </div> -->
                @endif
                @foreach($posts as $post)

                            <h3 class="pdf_box" style="text-align: center">
                                    	<span>
                            <strong>{{ $post->title }}</strong>
                            </span>
                            </h3>
                            <p>
                                {!! $post->description!!}
                            </p>
                        {{--<p>Период: с {{ date("d.m.Y",$v->start_period) }} до {{ date("d.m.Y",$v->end_period) }}</p>--}}

                        {{--<p>--}}
                            {{--Страны: @if(isset($v->countries))--}}
                                {{--@foreach($v->countries as $country )--}}
                                    {{--{{ $country->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--Тип ВВТ: @if(isset($v->vvttypes))--}}
                                {{--@foreach($v->vvttypes as $type )--}}
                                    {{--{{ $type->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--Компании: @if(isset($v->companies))--}}
                                {{--@foreach($v->companies as $item )--}}
                                    {{--{{ $item->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                        {{--<p>--}}
                            {{--Персоналии: @if(isset($v->personalities))--}}
                                {{--@foreach($v->personalities as $item )--}}
                                    {{--{{ $item->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                        <p class="pdf_gallery">
                            @if(isset($$post->images))
                                @foreach($$post->images as $image)
                                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                                @endforeach
                            @endif
                        </p>
                    <div class="more"></div>
                @endforeach
            @endforeach
@endsection
