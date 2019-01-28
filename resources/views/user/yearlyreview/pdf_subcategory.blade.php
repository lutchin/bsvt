@extends('layouts.pdf')

@section('content')
    @if($reporttitle)
        <h3 class="title" style="text-align: center">{{ $reporttitle }} за {{ date('Y', $report->category->report->start_date) }} год</h3>
    @endif

    @if($report->title)
    <h3 class="title" style="text-align: center">{{ $report->title }}</h3>
    @endif
    @foreach($report->articles as $article)

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
@endsection