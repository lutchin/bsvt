@extends('layouts.pdf')

@section('content')
    <h1 style="text-align: center">{{ $reporttitle }} <!--№ {{ $number }}--> за {{ date("Y",$start_date)}} год </h1>
    @foreach($report as $region)
        <h3 style="text-align: center">{{ $region->title }}</h3>
        <h3 style="text-align: center">Военно политическая обстановка в регионе</h3>
        <p><?php echo $region->overview ?></p>
        @foreach($region->countries as $infocountry)

            @if(isset($infocountry->title))
                <h3 class="title" style="text-align: center" >{{ $infocountry->title }}</h3>
            @endif

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
    @endforeach

@endsection

