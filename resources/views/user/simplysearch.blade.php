@extends('layouts.app')

@section('content')
    <h3 class="full_row_center title">Результаты поиска</h3>
    <div class="container search_result_box_items">
        <hr>
        @foreach($result as $group => $articles)
        
            @foreach($articles as $article)
<!--             
                <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a> -->

                @switch($group)
                    @case('weekly')
                    <div class="search_block">
                    <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a>
                    <p><!--strong>Анонс:</strong-->
                        {{   mb_substr(ltrim(html_entity_decode(strip_tags($article->body))), 0, 400) }}
                    </p>
                    <p>
                        <strong>Отчет:</strong> Еженедельный дайжест "Еженедельный обзор ВПО и ВТИ" за период от {{date("d.m.Y",$article->weeklyreport->start_date)}} по {{date("d.m.Y",$article->weeklyreport->end_date)}}
                    </p>
                    <p><strong>Раздел:</strong>
                      @if(isset($article->subcategory))
                          <span>{{ $article->subcategory->category->title }}</span></p>
                      @elseif(isset($article->category))
                          <span>{{ $article->category->title }}</span></p>
                      @elseif(isset($article->plannedexhibitionyear))
                          <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                      @elseif(isset($article->exhibitionyear))
                          <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                      @endif
                    </p>
                    </div>
                    @break


                    @case('monthly')
        @if(isset($article->monthlyreport))
                    <div class="search_block">
                    <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a>
                    <p><!--strong>Анонс:</strong-->
                        {{   mb_substr(ltrim(html_entity_decode(strip_tags($article->body))), 0, 400) }}
                    </p>
                    <p>
                        <strong>Отчет:</strong> Ежемесячный дайжест "Некоторые аспекты развития вооружений, военной и специальной техники за рубежом за период от {{date("d.m.Y",$article->monthlyreport->start_date)}} по {{date("d.m.Y",$article->monthlyreport->end_date)}}
                    </p>
                    <p><strong>Раздел:</strong>
                      @if(isset($article->subcategory))
                          <span>{{ $article->subcategory->category->title }}</span></p>
                      @elseif(isset($article->category))
                          <span>{{ $article->category->title }}</span></p>
                      @elseif(isset($article->plannedexhibitionyear))
                          <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                      @elseif(isset($article->exhibitionyear))
                          <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                      @endif
                    </p>
                    </div>
        @endif
                    @break


                    @case('countrycatalog')
                    <div class="search_block">
                    <a href="/{{$group}}/article/{{$article->id}}/{{ $article->region->countrycatalog_id }}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a>
                    <p><!--strong>Анонс:</strong-->
                        {{   mb_substr(ltrim(html_entity_decode(strip_tags($article->overview))), 0, 400) }}
                    </p>
                    <p>
                        <strong>Отчет:</strong> Справочник по иностранным государствам за период от {{date("d.m.Y",$article->region->countrycatalog->start_date)}} по {{date("d.m.Y",$article->region->countrycatalog->end_date)}}
                    </p>
                    <p><strong>Раздел:</strong>
                      @if(isset($article->region))
                          <span>{{ $article->region->title }}</span></p>
                      @elseif(isset($article->category))
                          <span>{{ $article->category->title }}</span></p>
                      @elseif(isset($article->plannedexhibitionyear))
                          <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                      @elseif(isset($article->exhibitionyear))
                          <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                      @endif
                    </p>
                    </div>
                    @break


                    @case('yearly')
                    <div class="search_block">
                    <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a>
                    <p><!--strong>Анонс:</strong-->
                        {{   mb_substr(ltrim(html_entity_decode(strip_tags($article->body))), 0, 400) }}
                    </p>
                    <p>
                        @if($article->category)
                        <strong>Отчет:</strong> Ежегодный дайджест за период от {{date("d.m.Y",$article->category->report->start_date)}} по {{date("d.m.Y",$article->category->report->end_date)}}
                        @elseif(isset($article->report))
                            <strong>Отчет:</strong> Ежегодный дайджест за период от {{date("d.m.Y",$article->report->start_date)}} по {{date("d.m.Y",$article->report->end_date)}}
                        @endif
                    </p>
                    <p><strong>Раздел:</strong>
                      @if(isset($article->subcategory))
                          <span>{{ $article->subcategory->category->title }}</span></p>
                      @elseif(isset($article->category))
                          <span>{{ $article->category->title }}</span></p>
                      @elseif(isset($article->plannedexhibitionyear))
                          <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                      @elseif(isset($article->exhibitionyear))
                          <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                      @endif
                    </p>
                    </div>
                    @break


                    @case('exhibition')
                    <div class="search_block search_block--exhibition">
                      <div class="search-block__item search-block__item-title">
                        <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo strip_tags ($article->title,"<p><a><h1><h2><h3><h4><h5><h6>") ;?></a>
                      </div>
                      <div class="search-block__item search-block__item-content">
                        <div class="search-block__item-cont">
                          <p><!--strong>Анонс:</strong-->
                              {{   html_entity_decode(strip_tags(substr($article->theme, 0, 400)),"<p><a><h1><h2><h3><h4><h5><h6>") }}
                          </p>
                        </div>
                        <div class="search-block__item-descr">
                          <p>
                            <strong>Отчет:</strong> Выставка за период от {{date("d.m.Y",$article->exhibitionyear->start_date)}} по {{date("d.m.Y",$article->exhibitionyear->end_date)}}
                          </p>
                          <p>
                            <strong>Раздел:</strong>
                            @if(isset($article->subcategory))
                                    <span>{{ $article->subcategory->category->title }}</span></p>
                            @elseif(isset($article->category))
                                <span>{{ $article->category->title }}</span></p>
                            @elseif(isset($article->plannedexhibitionyear))
                                <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                            @elseif(isset($article->exhibitionyear))
                                <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                            @endif
                          </p>
                        </div>
                      </div>
                    </div>
                    @break


                    @case('plannedexhibition')
                    <div class="search_block search_block--exhibition">
                      <div class="search-block__item search-block__item-title">
                        <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo strip_tags ($article->title,"<p><a><h1><h2><h3><h4><h5><h6>") ;?></a>
                      </div>
                      <div class="search-block__item search-block__item-content">
                        <div class="search-block__item-cont">
                          <p><!--strong>Анонс:</strong-->
                              {{   html_entity_decode(strip_tags(substr($article->theme, 0, 400))) }}
                          </p>
                        </div>
                        <div class="search-block__item-descr">
                          <p>
                            <strong>Отчет:</strong> Выставка за период от {{date("d.m.Y",$article->plannedexhibitionyear->start_date)}} по {{date("d.m.Y",$article->plannedexhibitionyear->end_date)}}
                          </p>
                          <p>
                            <strong>Раздел:</strong>
                              @if(isset($article->subcategory))
                                  <span>{{ $article->subcategory->category->title }}</span></p>
                              @elseif(isset($article->category))
                                  <span>{{ $article->category->title }}</span></p>
                              @elseif(isset($article->plannedexhibitionyear))
                                  <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                              @elseif(isset($article->exhibitionyear))
                                  <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                              @endif
                          </p>
                    
                        </div>
                      </div>
                    </div>                    
                    @break


                    @case('various')
                    @if(isset($article->report))
                    <div class="search_block">
                    <a href="/{{$group}}/article/{{$article->id}}" target="_blank" class="title_link text_decor"> <?php echo $article->title;?></a>
                    <p><!--strong>Анонс:</strong-->
                        {{   mb_substr(ltrim(html_entity_decode(strip_tags($article->body))), 0, 400) }}
                    </p>
                    @if(isset($article->subcategory))
                        <p>
                            <strong>Отчет:</strong> Иные материалы за период от {{date("d.m.Y",$article->subcategory->category->report->start_date)}} по {{date("d.m.Y",$article->subcategory->category->report->end_date)}}
                        </p>
                    @elseif(isset($article->category))
                        <p>
                            <strong>Отчет:</strong> Иные материалы за период от {{date("d.m.Y",$article->category->report->start_date)}} по {{date("d.m.Y",$article->category->report->end_date)}}
                        </p>
                    @else
                            <p>
                                <strong>Отчет:</strong> Иные материалы за период от {{date("d.m.Y",$article->report->start_date)}} по {{date("d.m.Y",$article->report->end_date)}}
                            </p>
                    @endif
                    <p><strong>Раздел:</strong>
                      @if(isset($article->subcategory))
                          <span>{{ $article->subcategory->category->title }}</span></p>
                      @elseif(isset($article->category))
                          <span>{{ $article->category->title }}</span></p>
                      @elseif(isset($article->plannedexhibitionyear))
                          <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                      @elseif(isset($article->exhibitionyear))
                          <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                          @endif
                    </p>
                    </div>
                    @endif
                    @break
                @endswitch
                <!-- {{ $article->report }}
                <p><strong>Раздел:</strong>
                    @if(isset($article->subcategory))
                        <span>{{ $article->subcategory->category->title }}</span></p>
                @elseif(isset($article->category))
                    <span>{{ $article->category->title }}</span></p>
                @elseif(isset($article->plannedexhibitionyear))
                    <span> Планируемые выставки {{ $article->plannedexhibitionyear->year }}</span></p>
                @elseif(isset($article->exhibitionyear))
                    <span> Планируемые выставки {{ $article->exhibitionyear->year }}</span></p>
                    @endif
                    </p> -->
                    <!-- <hr> -->
                    @endforeach
                    @endforeach
                    <div class="row box_save_article mt30">
                        <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                    </div>
    </div>

@endsection