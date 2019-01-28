@extends('layouts.pdf')

@section('content')
<h1 style="text-align: center">{{ $reporttitle }} за {{ date("Y",$report->countrycatalog->start_date) }} год. </h1>
<h3 style="text-align: center">{{ $report->title }}</h3>
<h3 style="text-align: center">Военно-политическая обстановка в регионе</h3>
<p><?php echo $report->overview ?></p>

    @foreach($report->countries()->get() as $infocountry)


        <h3 style="text-align: center">{{$infocountry->title}}</h3>

        <!-- @if(isset($infocountry->title))
            <h3 style="text-align: center" class="title">{{ $infocountry->title }}</h3>
        @endif -->

        <p>{!!   $infocountry->overview !!}</p>

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