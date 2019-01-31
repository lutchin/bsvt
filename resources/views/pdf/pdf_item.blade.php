@extends('layouts.pdf')

@section('content')
    @if($report_slug=='weekly')
        <h1 style="text-align: center">Бюллетень военно-политической и военно-технической информации № {{ $report->number }} за период с {{date("d.m.y",$report->date_start)}} по {{date("d.m.y",$report->date_end)}}</h1>
    @elseif($report_slug=='monthly')
        <h3 class="title" style="text-align: center">{{ $report->types->description}} ({{ Helper::getMonthText(date('m', $report->date_start)) }} {{ date('Y', $report->date_start) }})</h3>
    @elseif($report_slug=='countrycatalog')
        <h1 style="text-align: center">Ежегодный справочник {{ $report->types->description }} за {{ date("Y",$report->date_start) }} год. </h1>
    @endif

    @if(!empty($items))
        @foreach($items as  $category =>$sub_cats)

            <h3 class="title title_cat" style="text-align: center">{{ $category}}</h3>
            @if($report_slug == 'countrycatalog' && $descriptions[$loop->index])
            <h3 style="text-align: center">Военно-политическая обстановка в регионе</h3>
            <p>{!! $descriptions[$loop->index] !!}</p>
            @endif
            @foreach($sub_cats as  $sub_cat =>$posts)

            @if($sub_cat)
                <h3 class="title padl_sub1 title_sub_cat" style="text-align: center">
                    <strong>{{ $sub_cat  }}</strong>
                </h3>
            @endif
            @foreach($posts as $post)

                @if(isset($post))
                    @if(isset($post->title))
                        <h3 class="title" style="text-align: center">{{ $post->title }}</h3>
                    @endif

                    <p>{!! $post->description !!}</p>

                    <p class="pdf_gallery">
                        @if(isset($post->images))
                            @foreach($post->images as $image)
                                <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                            @endforeach
                        @endif
                    </p>

                @endif
                <div class="more"></div>
            @endforeach

            @endforeach

        @endforeach
    @endif




    {{--@if(!empty($report))--}}

        {{--@if(!empty($report->articles))--}}
            {{--@foreach($report->articles as  $article)--}}
                {{--@if(!isset($article->category) && !isset($article->subcategory))--}}
                    {{--<div class="row padl1 out_list_title">--}}
                    {{--@if(isset($article->title))--}}
                    {{--<h3 class="title" style="text-align: center">{{ $article->title }}</h3>--}}
                    {{--@endif--}}
                    {{--<p>{!!   $article->description !!}</p>--}}

                    {{--</div>--}}
                {{--@endif--}}
            {{--@endforeach--}}
        {{--@endif--}}



    {{--@foreach($categories as $category)--}}
        {{--@if(count($category->article_reports) != 0  && $category->article_reports->contains('report_id', $report->id) )--}}
            {{--<div class="row">--}}
            {{--<h3 class="title title_cat" style="text-align: center">--}}
                {{--{{ $category->title }}--}}
            {{--</h3>--}}
            {{--</div>--}}
            {{--@if( $report->types->slug == 'countrycatalog')--}}
                {{--<div class="row padl_sub2 out_list_title">--}}
                    {{--<div class="vpor_box">--}}
                        {{--<p class="vpor_title">Военно-политическая обстановка в регионе--}}

                        {{--</p>--}}
                        {{--<div class="vpor_desc" style="display:none;">--}}
                            {{--{!!$category->description !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
        {{--@endif--}}
        {{--@if( $report->types->slug != 'various')--}}
            {{--@if(!empty($items))--}}
                {{--@foreach($items as  $cat =>$articles)--}}
                    {{--@if(isset($articles))--}}
                        {{--@foreach($articles as  $article)--}}
                            {{--@if($cat == $category->title)--}}
                                {{--<div class="row padl1 out_list_title">--}}
                                    {{--@if(isset($article->title))--}}
                                        {{--<h3 class="title" style="text-align: center">{{ $article->title }}</h3>--}}
                                    {{--@endif--}}
                                    {{--<p>{!!   $article->description !!}</p>--}}

                                {{--</div>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--@endif--}}
        {{--@if(!empty($category->subcategories))--}}
            {{--@foreach($category->subcategories as  $subcategory)--}}
                {{--@if(count($subcategory->article_reports) != 0)--}}
                    {{--<div class="row padl_sub1 out_list_title">--}}

                        {{--<p class="title">{{ $subcategory->title }}</p>--}}

                        {{--@if(!empty($subcategory->article_reports))--}}
                            {{--@foreach($subcategory->article_reports as  $article)--}}
                                {{--@if($article->subcategory)--}}
                                    {{--<div class="row padl1 out_list_title">--}}
                                        {{--@if(isset($article->title))--}}
                                            {{--<h3 class="title" style="text-align: center">{{ $article->title }}</h3>--}}
                                        {{--@endif--}}
                                        {{--<p>{!!   $article->description !!}</p>--}}

                                    {{--</div>--}}
                                {{--@endif--}}
                            {{--@endforeach--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
                    {{--@endif--}}
                    {{--@endforeach--}}
    {{--@endif--}}
@endsection