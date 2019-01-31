<?php $role = Auth::user()->roles[0]->title;

$d = date("d");
$m = date("m");
$y = date("Y");
?>


@extends('layouts.app')

@section('content')

    <div class="container add_form_step2 posr">
        <h3 class="title">
            <span>
                @if($report->types->slug=='weekly')
                            {{ $report->types->title }} № {{ $report->number }} за период от {{date("d.m.Y",$report->date_start)}} до {{date("d.m.Y",$report->date_end)}}
                @elseif($report->types->slug=='monthly')
                        {{$report->types->title}} № {{ $report->number }} ({{ Helper::getMonthText(date('m', $report->date_start)) }} {{ date('Y', $report->date_start) }})
                @elseif($report->types->slug=='countrycatalog')
                        Ежегодный справочник "{{ $report->types->title }}" за {{date("Y",$report->date_start)}} год
                    @elseif($report->types->slug=='yearly')
                    Ежегодный справочник "{{ $report->types->title}}" <!--№ {{ $report->number }}--> за {{date("Y",$report->date_start)}} год
                @endif
                    <a target="_blank" href="/pdf_item/{{ $report->id }}" class="pdf"></a>
               </span>
            </h3>

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
                @if($report->types->slug=='yearly')

                        @foreach($items as  $report)
                            @if(!empty($report->articlesReport))
                                @foreach($report->articlesReport as  $article)
                                    <div class="row padl_sub2 out_list_title">
                                        <p class="pdf_box">
                                            <a href="/yearly/article/{{ $article->id }}">
                                                <strong>{{ $article->title }}</strong>
                                            </a>
                                            <a target="_blank" href="/yearly/pdf_article/{{ $article->id }}" class="pdf"></a>
                                        </p>
                                        <?php
                                        $description = explode(' ', ltrim(html_entity_decode(strip_tags($article->body))));
                                        count($description) <40 ? $count = count($description): $count = 40;
                                        $descrurtion_short = implode(' ', array_slice($description,0, $count));
                                        ?>
                                        <p style="text-align: justify">
                                            <span>{{$descrurtion_short}}...</span>
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                            @if(!empty($report->categories))
                                @foreach($report->categories as  $category)
                                    <div class="row out_list_title mt10">
                                        <p class="title">
                                            {{ $category->title }}
                                            <span>
                                            <a target="_blank" href="/yearly/pdf_category/{{ $category->id }}" class="pdf"></a>
                                        </span>
                                        </p>
                                        @if(!empty($category->articles))
                                            @foreach($category->articles as  $catarticle)
                                                <div class="row padl_sub2 out_list_title">
                                                    <p class="pdf_box">
                                                        <a href="/yearly/article/{{ $catarticle->id }}">
                                                            <strong>{{ $catarticle->title }}</strong>
                                                        </a>
                                                        <a target="_blank" href="/yearly/pdf_article/{{ $catarticle->id }}" class="pdf"></a>
                                                    </p>
                                                    <?php
                                                    $description = explode(' ', ltrim(html_entity_decode(strip_tags($catarticle->body))));
                                                    count($description) <40 ? $count = count($description): $count = 40;
                                                    $descrurtion_short = implode(' ', array_slice($description,0, $count));
                                                    ?>
                                                    <p style="text-align: justify">
                                                        <span>{{$descrurtion_short}}...</span>
                                                    </p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @if(!empty($category->subcategories))
                                        @foreach($category->subcategories as  $subcategory)
                                            <div class="row padl_sub1 out_list_title">

                                                <p class="pdf_box">
                                                    {{ $subcategory->title }}
                                                    <span>
                                                        <a target="_blank" href="/yearly/pdf_subcategory/{{ $subcategory->id }}" class="pdf"></a>
                                                    </span>
                                                </p>

                                                @if(!empty($subcategory->articles))
                                                    @foreach($subcategory->articles as  $article)
                                                        <div class="row padl_sub2 out_list_title">
                                                            <p class="pdf_box">
                                                                <a href="/yearly/article/{{ $article->id }}">
                                                                    {{ $article->title }}
                                                                </a>
                                                                <a target="_blank" href="/yearly/pdf_article/{{ $article->id }}" class="pdf"></a>
                                                            </p>
                                                            <?php
                                                            $description = explode(' ', ltrim(html_entity_decode(strip_tags($article->body))));
                                                            count($description) <40 ? $count = count($description): $count = 40;
                                                            $descrurtion_short = implode(' ', array_slice($description,0, $count));
                                                            ?>
                                                            <p style="text-align: justify">
                                                                <span>{{$descrurtion_short}}...</span>
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                @else


                <?php $n1 = 0; $n2 = 0; $n3 = 0; ?>
                @foreach($items as  $cat => $posts)
                        <?php $n1++; ?>
                        <div class="row">
                            @if($report->types->slug=='monthly')
                                <p class="title title_cat">
                                    {{ $n1 }}. {{ $cat }}
                            @elseif($report->types->slug=='weekly' || $report->types->slug=='countrycatalog')
                                <p class="title title_cat pdf_box">
                                    <span>{{ $cat }}</span>
                            @endif
                                <span>
	                            <a target="_blank" href="/pdf_category/{{$report->id}}/{{ \App\Category::where('title',$cat)->first()->id }}" class="pdf"></a>
                                </span>
                            </p>
                        </div>

                        @include('report.layouts.'.$report->types->slug.'_show')

                @endforeach
                    @endif
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


@if($report->types->slug=='countrycatalog')
    @section('scripts')
        <script type="text/javascript" charset="utf-8">
            jQuery(document).ready(function() {
                jQuery('.vpor_title').on('click',function() {

                    if(jQuery(this).parent('.vpor_box').hasClass('active')) {
                        jQuery(this).parent('.vpor_box').removeClass('active');
                        jQuery('.vpor_box .vpor_desc').fadeOut(500);
                    } else {
                        jQuery(this).parent('.vpor_box').addClass('active');
                        jQuery('.vpor_box.active .vpor_desc').fadeIn(500);
                    }

                })
            })

        </script>
    @endsection
@endif


