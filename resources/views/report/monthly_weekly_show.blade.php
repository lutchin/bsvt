<?php $role = Auth::user()->roles[0]->title;

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
} ?>


@extends('layouts.app')

@section('content')

    <div class="container add_form_step2 posr">
        @if($report->types->slug=='weekly')
            <h3 class="title">{{ $report->types->description }} № {{ $report->number }} за период от {{date("d.m.Y",$report->date_start)}} до {{date("d.m.Y",$report->date_end)}}
                <span>
            		<a target="_blank" href="/{{  $report->types->slug }}/pdf_item/{{ $report->id }}" class="pdf"></a>
            	</span>
            </h3>
        @elseif($report->types->slug=='monthly')

        <h3 class="title">{{$report->types->description}} № {{ $report->number }} ({{ getMonthText(date('m', $report->start_date)) }} {{ date('Y', $report->start_date) }})
    		<span>
				<a target="_blank" href="/monthly/pdf_item/{{ $report->id }}" class="pdf"></a>
			</span>
        </h3>
        @endif
        @if( $role != 'user' && $role !='employee' )
            <span class="pos_tr_article_out status st-{{10 + $report->status}}">
            	@if($report->status == 2)
                    <span class="status st_inherit">Статус:</span> Опубликован
                @elseif($report->status == 1)
                    <span class="status st_inherit">Статус:</span> Все материалы утверждены
                @elseif($report->status == 0)
                    <span class="status st_inherit">Статус:</span> Не опубликован

                @endif
            </span>
    @endif
            @if(!empty($items))
                <?php $n1 = 0; $n2 = 0; $n3 = 0; ?>
                @foreach($items as  $cat => $posts)
                        <?php $n1++; ?>
                        <div class="row">
                            @if($report->types->slug=='monthly')
                                <p class="title title_cat">
                                    {{ $n1 }}. {{ $cat }}
                            @elseif($report->types->slug=='weekly')
                                <p class="title title_cat pdf_box">
                                    <span>{{ $cat }}</span>
                            @endif
                                <span>
	                            <a target="_blank" href="/{{ $report->types->slug }}/pdf_category/{{ $report->id }}/{{ \App\Category::where('title',$cat)->first()->id }}" class="pdf"></a>
                                </span>
                            </p>
                        </div>

                            @if($report->types->slug=='weekly')

                            @include('report.layouts.weekly_show')

                            @elseif($report->types->slug=='monthly')

                                @include('report.layouts.monthly_show')

                            @endif

                @endforeach
            @endif




            <div class="row box_save_article mt30">
                @if(Request::url() == URL::previous())
                    <a href="/{{ $report->types->slug }}/" class="button butt_back">Все отчеты</a>
                @else
                    <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                @endif
                @if( $role != 'user' && $role !='employee' )
                    <a class="button butt_def" href="/{{ $report->types->slug }}/add2/{{ $report->id }}">Редактировать</a>
                @endif
            </div>


    </div>
@endsection