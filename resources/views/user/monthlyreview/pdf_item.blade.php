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
    <div class="pdf_wrap">
    <h3 class="title pdf_title"> Некоторые аспекты развития вооружений, военной и специальной техники за рубежом ({{ getMonthText(date('m', $start_date)) }} {{ date('Y', $start_date) }})</h3>
    <?php $n1 = 0; $n2 = 0; $n3 = 0; ?>
    @foreach($report as  $cat =>$item)
        @if($cat != 'false')
            <?php $n1++; ?>
            <div class="row cat">
                <h3 class="title title_cat">
                    {{ $n1 }}. {{ $cat }}
                </h3>
            </div>

            @foreach($item as  $key =>$value)
                @if($key !== 'false')
                    <?php $n2++; ?>
                    <div class="row sub_cat">
                        <h3 class="title padl_sub1 title_sub_cat">
                            {{ $n1 }}.{{ $n2 }}. {{ $key }}
                        </h3>
                    </div>
                @endif
                {{--<br>--}}
                @foreach($value as  $k =>$v)
                    @if(isset($v))
                        <?php $n3++; ?>
                        <div class="row padl_sub2 out_list_title">
                            <h3 class="title pdf_box">
                                {{ $v->title }}
                            </h3>
                            <p>
                                {!! $v->body !!}
                            </p>
                        </div>

                        <p class="pdf_gallery">
                            @if(isset($v->monthlyimages))
                                @foreach($v->monthlyimages as $image)
                                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                                @endforeach
                            @endif
                        </p>
                        <div class="more"></div>
                        <br>
                    @endif
                @endforeach
                <br>
            @endforeach
        @endif
    @endforeach
    </div>
@endsection
