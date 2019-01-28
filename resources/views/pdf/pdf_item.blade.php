@extends('layouts.pdf')

@section('content')
    <h1 style="text-align: center">Бюллетень военно-политической и военно-технической информации № {{ $report->number }} за период от {{date("d.m.y",$report->date_start)}} до {{date("d.m.y",$report->date_end)}}</h1>
    {{--<p>Тип отчета: {{ $reporttitle }}</p>--}}
    {{--<p>Период: с {{date("d",$weeklyreport->start_date)}} до {{date("d",$weeklyreport->end_date)}}</p>--}}
    {{--@if(!empty($report))--}}
        {{--@foreach($report as  $cat => $posts)--}}
            {{--<div class="row">--}}
                {{--<h3 class="title title_cat" style="text-align: center">--}}
                    {{--{{ $cat }}--}}
                {{--</h3>--}}
            {{--</div>--}}
            {{--@foreach($posts as  $post)--}}
                {{--@if(isset($post))--}}
                    {{--@if (is_array($post))--}}
                        {{--@foreach($post as $article)--}}

                            {{--<div class="row padl1 out_list_title">--}}
                                {{--@if(isset($article->title))--}}
                                    {{--<h3 class="title" style="text-align: center">{{ $article->title }}</h3>--}}
                                {{--@endif--}}
                                {{--<p>{!!   $article->body !!}</p>--}}

                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--@else--}}
                    {{--<div class="row padl1 out_list_title">--}}

                        {{--<p>Страны: @if(isset($post->countries))--}}
                                {{--@foreach($post->countries as $country )--}}
                                    {{--{{ $country->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif</p>--}}

                        {{--<p>Тип ВВТ: @if(isset($post->vvttypes))--}}
                                {{--@foreach($post->vvttypes as $type )--}}
                                    {{--{{ $type->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                        {{--<p>Компании: @if(isset($post->companies))--}}
                                {{--@foreach($post->companies as $item )--}}
                                    {{--{{ $item->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}

                        {{--<p>Персоналии: @if(isset($post->personalities))--}}
                                {{--@foreach($post->personalities as $item )--}}
                                    {{--{{ $item->title }},--}}
                                {{--@endforeach--}}
                            {{--@endif</p>--}}

                        {{--@if(isset($post->title))--}}
                            {{--<h3 class="title" style="text-align: center">{{ $post->title }}</h3>--}}
                        {{--@endif--}}
                        {{--<p>{!!   $post->body !!}</p>--}}

                        {{--<p class="pdf_gallery">--}}
                            {{--@if(isset($post->weeklyimages))--}}
                                {{--@foreach($post->weeklyimages as $image)--}}
                                    {{--<img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--@endif--}}
                {{--@endif--}}
                {{--<br>--}}
            {{--@endforeach--}}

        {{--@endforeach--}}
    {{--@endif--}}

    @if(!empty($report))

        @if(!empty($report->articles))
            @foreach($report->articles as  $article)
                @if(!isset($article->category) && !isset($article->subcategory))
                    <div class="row padl1 out_list_title">
                    @if(isset($article->title))
                    <h3 class="title" style="text-align: center">{{ $article->title }}</h3>
                    @endif
                    <p>{!!   $article->description !!}</p>

                    </div>
                @endif
            @endforeach
        @endif



    @foreach($categories as $category)
        @if(count($category->article_reports) != 0  && $category->article_reports->contains('report_id', $report->id) )
            <div class="row">
            <h3 class="title title_cat" style="text-align: center">
                {{ $category->title }}
            </h3>
            </div>
            @if( $report->types->slug == 'countrycatalog')
                <div class="row padl_sub2 out_list_title">
                    <div class="vpor_box">
                        <p class="vpor_title">Военно-политическая обстановка в регионе

                        </p>
                        <div class="vpor_desc" style="display:none;">
                            {!!$category->description !!}
                        </div>
                    </div>
                </div>
            @endif
        @endif
        @if( $report->types->slug != 'various')
            @if(!empty($items))
                @foreach($items as  $cat =>$articles)
                    @if(isset($articles))
                        @foreach($articles as  $article)
                            @if($cat == $category->title)
                                <div class="row padl1 out_list_title">
                                    @if(isset($article->title))
                                        <h3 class="title" style="text-align: center">{{ $article->title }}</h3>
                                    @endif
                                    <p>{!!   $article->description !!}</p>

                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endif
        @if(!empty($category->subcategories))
            @foreach($category->subcategories as  $subcategory)
                @if(count($subcategory->article_reports) != 0)
                    <div class="row padl_sub1 out_list_title">

                        <p class="title">{{ $subcategory->title }}</p>

                        @if(!empty($subcategory->article_reports))
                            @foreach($subcategory->article_reports as  $article)
                                @if($article->subcategory)
                                    <div class="row padl1 out_list_title">
                                        @if(isset($article->title))
                                            <h3 class="title" style="text-align: center">{{ $article->title }}</h3>
                                        @endif
                                        <p>{!!   $article->description !!}</p>

                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    @endif
                @endforeach
                    @endif
                    @endforeach

    @endif

@endsection