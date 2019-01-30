@extends('layouts.pdf')

@section('content')
<h1 style="text-align: center">{{ $report->types->description }} за {{ date("Y",$report->start_date) }} год. </h1>
<h3 style="text-align: center">{{ $category }}</h3>
<h3 style="text-align: center">Военно-политическая обстановка в регионе</h3>
<p>{{$report->overview}}</p>

    @foreach($report_array as $infocountry)

        @if(isset($infocountry->title))
            <h3 style="text-align: center">{{$infocountry->title}}</h3>
        @endif

        <p>{!!   $infocountry->description !!}</p>

        <p class="pdf_gallery">
            @if(isset($infocountry->images))
                @foreach($infocountry->images as $image)
                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                @endforeach
            @endif
        </p>
        <br>

    @endforeach

@endsection