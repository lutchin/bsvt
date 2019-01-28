@extends('layouts.pdf')

@section('content')
    <h1  style="text-align: center">{{ $reporttitle }} за {{ date("Y",$report->report->start_date)}} год</h1>
    @foreach($report->articles as $article)
        {{--<h1  style="text-align: center">{{ $reporttitle }} за {{ date("Y",$report->report->start_date)}} год</h1>--}}
        @if($article->subcategory)
            <h3 style="text-align: center"> {{ $article->subcategory->title }}</h3>
            <h3 style="text-align: center"> {{ $article->subcategory->category->title }}</h3>
        @else
            <h3 style="text-align: center"> {{ $article->category->title }}</h3>
        @endif

        @if(isset($article->title))
            <h3 class="title"  style="text-align: center">{{ $article->title }}</h3>
        @endif
        <p>{!!   $article->body !!}</p>
        <p class="pdf_gallery">
            @if(isset($article->images))
                @foreach($article->images as $image)
                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                @endforeach
            @endif
        </p>
        
        <div class="more"></div>
    @endforeach
    @foreach($report->subcategories as $subcategory)
        @if($subcategory->title)
            <h3 style="text-align: center">{{ $subcategory->title }}</h3>
        @endif
        @foreach($subcategory->articles as $article)
            @if(isset($article->title))
                <h3 class="title" style="text-align: center">{{ $article->title }}</h3>
            @endif
            <p>{!!   $article->body !!}</p>
            <p class="pdf_gallery">
                @if(isset($article->images))
                    @foreach($article->images as $image)
                        <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                    @endforeach
                @endif
            </p>
        @endforeach
    @endforeach
@endsection