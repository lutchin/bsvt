<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row co_l2">
                    <div class="col-md-6 item_card">
                        <h5>Бюллетень военно-политической и военно-технической информации</h5>
                        <p>Еженедельный отчет</p>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($week_articles as $week_article)
                                <li><a href="/weekly/show/{{ $week_article->id }}">Отчет с {{ date("d",$week_article['start_date'])  }}.{{ $week_article['month'] }} по {{ date("d",$week_article['end_date']) }}.{{ $week_article['month']}}.{{$week_article['year'] }}</a></li>
                            @endforeach
                        </ul>
                        <a href="/weekly"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/weekly/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/weekly"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                    <div class="col-md-6 item_card">
                        <h5>Некоторые аспекты развития вооружений, военной и специальной техники за рубежом</h5>
                        <p>Ежемесячный бюллетень</p>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($month_articles as $article)
                                <li><a href="/monthly/show/{{ $article->id }}">Отчет за период {{ $article->month }}.{{ $article->year }}</a></li>
                            @endforeach
                        </ul>
                        <a href="/monthly"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/monthly/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/monthly"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                </div>
                <div class="row co_l2">
                    <div class="col-md-6 item_card">
                        <h5>Об основных направлениях и тенденциях развития вооружений и военной техники в зарубежных государствах</h5>
                        <p>Ежегодный справочник</p>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($year_articles as $year_article)
                                <li><a href="/yearly/show/{{ $year_article->id }}">Отчет за {{date("Y",$year_article->start_date)}} год.</a></li>
                            @endforeach
                        </ul>
                        <a href="/monthly"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/yearly/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/yearly"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                    <div class="col-md-6 item_card">
                        <h5>Справочник по иностранным государствам</h5>
                        <p>Ежегодный обзор</p>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($countrycatalogs as $countrycatalog)
                                <li><a href="/countrycatalog/show/{{ $countrycatalog->id }}">Отчет за {{date("Y", $countrycatalog->start_date) }} год.</a></li>
                            @endforeach
                        </ul>
                        <a href="/countrycatalog"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/countrycatalog/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/countrycatalog"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                </div>
                <div class="row co_l2">
                    <div class="col-md-6 item_card">
                        <h5>Перечень международных выставок ВВТ, планируемых к проведению в иностранных государствах</h5>
                        <p>Ежегодный календарь</p>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($plannedexhibitionsyears as $plannedexhibition)
                                <li><a href="/plannedexhibition/show/{{ $plannedexhibition->id }}">Отчет за {{date("Y",$plannedexhibition->start_date)}} год.</a></li>
                            @endforeach
                        </ul>
                        <a href="/plannedexhibition"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/plannedexhibition/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/plannedexhibition"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                    <div class="col-md-6 item_card">
                        <h5>Иные материалы</h5>
                        @if( $role == 'user' || $role =='employee' )
                        <ul class="ul_1_user">
                            @foreach($various_articles as $various_article)
                                <li><a href="/various/show/{{ $various_article->id }}">{{ $various_article->number }} {{--{{ date("d",$various_article['start_date'])  }}.{{ $various_article['month'] }} по {{ date("d",$various_article['end_date']) }}.{{ $various_article['month']}}.{{$various_article['year'] }}--}}</a></li>
                            @endforeach
                        </ul>
                        <a href="/various"><button class="butt no_wrap">Все материалы раздела</button></a>
                        @else
                            <a href="/analyst/various/add1"><button class="butt margin_b">Создать отчет</button></a>
                            <a href="/analyst/various"><button class="butt">Управление отчетами</button></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
