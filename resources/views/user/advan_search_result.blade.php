@extends('layouts.app')

@section('content')
    <h3 class="full_row_center title">Результаты поиска</h3>

    <div class="container border search_result_box">
        <p>
            <strong>Тип отчета:</strong>
            @if(is_object($report_type))
                {{$report_type->title}}
            @else
                Все отчеты
            @endif
        </p>
        <p>
            <strong>Период: </strong>
            <span class="italic_14">c {{date("d.m.Y",$start_period)}} по {{date("d.m.Y",$end_period)}}</span>
        </p>
        @if($countries->count()!=0)
            <p>
                <strong>Страны:</strong>
                @foreach($countries as $key => $country )
                    <?php if( $key == 0) {
                        echo $country->title;
                    } else{
                        echo ', '.$country->title;
                    }?>
                @endforeach
            </p>
        @endif
        @if($vvt_types->count()!=0)
            <p>Тип ВВТ:
                @foreach($vvt_types as $key => $vvt_type )
                    <?php if( $key == 0) {
                        echo $vvt_type->title;
                    } else{
                        echo ', '.$vvt_type->title;
                    }?>
                @endforeach
            </p>
        @endif
        @if($companies->count()!=0)
            <p>Компании: @foreach($companies as $key => $company )
                    <?php if( $key == 0) {
                        echo $company->title;
                    } else{
                        echo ', '.$company->title;
                    }?>
                @endforeach
            </p>
        @endif
        @if($personalities->count()!=0)
            <p>Персоналии: @foreach($personalities as $key => $personality )
                   <?php if( $key == 0) {
                        echo $personality->title;
                   } else{
                        echo ', '.$personality->title;
                   }?>
                @endforeach
            </p>
        @endif
    </div>

    <div class="container search_result_box_items">
        <hr>
        @if(isset($articles['weekly']))
            @foreach($articles['weekly'] as $item)
                <div class="search_block">
                    <a href="/weekly/article/{{$item->id}}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--strong>Анонс:</strong-->
                     {{ mb_substr(ltrim(html_entity_decode(strip_tags($item->body))),0,200) }}

                    </p>
                    <p>
                        <strong>Отчет: </strong> <a class="report" href="/weekly/show/{{$item->weeklyreport_id}}"
                                                    target="_blank">Еженедельный дайжест "Еженедельный обзор ВПО и ВТИ" за период от {{date("d.m.Y",$item->weeklyreport->start_date)}} по {{date("d.m.Y",$item->weeklyreport->end_date)}}</a>
                    </p>
                    <p><strong>Раздел: </strong> {{\App\Category::find($item->category_id)->title}}</p>
                </div>
            @endforeach
        @endif
        @if(isset($articles['monthly']))
            @foreach($articles['monthly'] as $item)
                @if(isset($item->monthlyreport))
                <div class="search_block">
                    <a href="/monthly/article/{{$item->id}}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--<strong>Кpаткое описание:</strong>-->
                        {{ mb_substr(html_entity_decode(strip_tags($item->body)),0,200) }}
                    </p>
                    <p>
                        <strong>Отчет: </strong> <a class="report"
                                                   href="/monthly/show/{{$item->monthlyreport_id}}">Ежемесячный
                                                                                                  дайжест "Некоторые аспекты развития вооружений, военной и специальной техники за рубежом за период от {{date("d.m.Y",$item->monthlyreport->start_date)}} по {{date("d.m.Y",$item->monthlyreport->end_date)}}</a>
                    </p>
                    <p><strong>Раздел: </strong> {{\App\Category::find($item->category_id)->title}}</p>
                   @if(isset($item->subcategory_id))
                    <p><strong>Позраздел:</strong> {{\App\Subcategory::find($item->subcategory_id)->title}}</p>
                    @endif
                </div>
                @endif
            @endforeach
        @endif
        @if(isset($articles['yearly']))
            @foreach($articles['yearly'] as $item)
                <div class="search_block">
                    <a href="/yearly/article/{{$item->id}}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--strong>Анонс:</strong-->
                        {{ mb_substr(html_entity_decode(strip_tags($item->body)),0,200) }}
                    </p>
                    @if(isset($item->subcategory))
                        <p>
                            <strong>Отчет: </strong><a class="report" href="/yearly/show/{{$item->yearlyreport_id}}">
                                Ежегодный
                                                                                                       дайжест "Некоторые аспекты развития вооружений, военной и специальной техники за рубежом за период от {{date("d.m.Y",$item->subcategory->category->report->start_date)}} по {{date("d.m.Y",$item->subcategory->category->report->end_date)}}</a>
                        </p>

                        <p><strong>Раздел: </strong> {{ $item->subcategory->category->title }}</p>
                        <p><strong>Позраздел: </strong> {{ $item->subcategory->title }}</p>
                    @elseif(isset($item->category))
                        <p>
                            <strong>Отчет: </strong> <a class="report"
                                                       href="/yearly/show/{{$item->yearlyreport_id}}">Ежегодный
                                                                                                       дайжест "Некоторые аспекты развития вооружений, военной и специальной техники за рубежом за период от {{date("d.m.Y",$item->category->report->start_date)}} по {{date("d.m.Y",$item->category->report->end_date)}}</a>
                        </p>
                        <p><strong>Раздел: </strong> {{ $item->category->title }}
                    @else
                        <p>
                            <strong>Отчет: </strong> <a class="report"
                                                        href="/yearly/show/{{$item->yearlyreport_id}}">Ежегодный
                                дайжест "Некоторые аспекты развития вооружений, военной и специальной техники за рубежом за период от {{date("d.m.Y",$item->report->start_date)}} по {{date("d.m.Y",$item->report->end_date)}}</a>
                        </p>

                    @endif
                </div>
            @endforeach

        @endif
        @if(isset($articles['countrycatalog']))
            @foreach($articles['countrycatalog'] as $item)
                <div class="search_block">
                    <a href="/countrycatalog/article/{{$item->id}}/{{ $item->region->countrycatalog->id }}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--strong>Анонс:</strong-->
                        {{ mb_substr(html_entity_decode(strip_tags($item->overview)),0,200) }}
                    </p>

                    <p>
                        <strong>Отчет: </strong><a class="report"
                                                  href="/countrycatalog/show/{{$item->region_id}}">Справочник по
                                                                                                    иностранным государствам за период от {{date("d.m.Y",$item->region->countrycatalog->start_date)}} по {{date("d.m.Y",$item->region->countrycatalog->end_date)}}</a>
                    </p>

                    <p><strong>Регион: </strong> {{ $item->region->title }}</p>
                </div>
            @endforeach

        @endif


        @if(isset($articles['plannedexhibition']))
            <div class="exhibitions">Выставки</div>
            @foreach($articles['plannedexhibition'] as $item)
                <div class="search_block search_block--exhibition">
                    <div class="search-block__item search-block__item-title">
                        <a href="/plannedexhibition/article/{{$item->id}}" target="_blank" class="title_link
                        text_decor">
                            <?php echo
                                strip_tags ($item->title, "<p><a><h1><h2><h3><h4><h5><h6>");
                            ?>
                        </a>
                    </div>

                    <!--strong>Анонс:</strong-->
                    <div class="search-block__item search-block__item-content">
                        <div class="search-block__item-cont">
                           <?php echo
                               strip_tags ($item->theme, "<p><a><h1><h2><h3><h4><h5><h6>");
                           ?>
                        </div>

                       <div class="search-block__item-descr">
                           <p>
                               <strong>Отчет: </strong><a class="report"
                                                          href="/plannedexhibition/show/{{$item->plannedexhibition_id}}">Выставка за период от {{date("d.m.Y",$item->plannedexhibitionyear->start_date)}} по {{date("d.m.Y",$item->plannedexhibitionyear->end_date)}}</a>
                           </p>

                           <p><strong>Раздел: </strong> Выставки за {{ $item->plannedexhibitionyear->year }} год</p>
                       </div>
                    </div>

                </div>
            @endforeach

        @endif
        @if(isset($articles['exhibition']))
            @foreach($articles['exhibition'] as $item)
                <div class="search_block">
                    <a href="/exhibition/article/{{$item->id}}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--strong>Анонс:</strong-->
                        {{ mb_substr(html_entity_decode(strip_tags($item->theme)),0,200) }}
                    </p>

                    <p>
                        <strong>Отчет: </strong><a class="report" href="/exhibition/show/{{$item->exhibition_id}}">
                            Выставка за
                                                                                                     период от {{date("d.m.Y",$item->exhibitionyear->start_date)}} по {{date("d.m.Y",$item->exhibitionyear->end_date)}}</a>
                    </p>

                    <p><strong>Раздел: </strong> Выставки за {{ $item->exhibitionyear->year }} год</p>
                </div>
            @endforeach

        @endif
        @if(isset($articles['various']))
            @foreach($articles['various'] as $item)
                @if(isset($item->report))
                <div class="search_block">
                    <a href="/various/article/{{$item->id}}" target="_blank" class="title_link text_decor">{{$item->title}}</a>
                    <p><!--strong>Анонс:</strong-->
                        {{ mb_substr(html_entity_decode(strip_tags($item->body)),0,200) }}
                    </p>
                    {{--@if(isset($item->subcategory))--}}
                        <p>
                            <strong>Отчет: </strong><a class="report" href="/various/show/{{$item->variousreport_id}}"> {{ $item->report->number }} за
                                                                                                   период от {{date("d.m.Y",$item->report->start_date)}} по {{date("d.m.Y",$item->report->end_date)}}</a>
                        </p>
                        {{--<p><strong>Раздел: </strong> {{ $item->subcategory->category->title }}</p>--}}
                        {{--<p><strong>Позраздел: </strong> {{ $item->subcategory->title }}</p>--}}
                    {{--@else--}}
                        {{--<p>--}}
                            {{--<strong>Отчет: </strong><a class="report" href="/various/show/{{$item->various_id}}"> Иные--}}
                                                                                                            {{--материалы за--}}
                                                                                                   {{--рубежом за период от {{date("d.m.Y",$item->category->report->start_date)}} по {{date("d.m.Y",$item->category->report->end_date)}}</a>--}}
                        {{--</p>--}}
                        {{--<p><strong>Раздел: </strong> {{ $item->category->title }}--}}
                    {{--@endif--}}
                </div>
                @endif
            @endforeach

        @endif


        <div class="row box_save_article mt30">
            <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
        </div>

    </div>

@endsection
    
