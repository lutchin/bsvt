@extends('layouts.pdf')

@section('content')
    <h1 style="text-align: center">Бюллетень военно-политической и военно-технической информации № {{ $report->number }} за период с {{date("d.m.y",$report->date_start)}} по {{date("d.m.y",$report->date_end)}}</h1>

    @if(!empty($report_array))

                <h3 class="title title_cat" style="text-align: center">
                    {{ $category }}
                </h3>

            @foreach($report_array as $post)
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

    @endif



@endsection