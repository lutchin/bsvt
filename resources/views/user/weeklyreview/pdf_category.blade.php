@extends('layouts.pdf')

@section('content')
    <h1 style="text-align: center">Бюллетень военно-политической и военно-технической информации № {{ $report->number }} за период с {{date("d.m.y",$report->start_date)}} по {{date("d.m.y",$report->end_date)}}</h1>

    @if(!empty($article))
        @foreach($article as  $cat => $posts)

                <h3 class="title title_cat" style="text-align: center">
                    {{ $cat }}
                </h3>

            @foreach($posts as  $post)
                @if(isset($post))


                        @if(isset($post->title))
                            <h3 class="title" style="text-align: center">{{ $post->title }}</h3>
                        @endif

                        <p>{!!   $post->body !!}</p>

                        <p class="pdf_gallery">
                            @if(isset($post->weeklyimages))
                                @foreach($post->weeklyimages as $image)
                                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                                @endforeach
                            @endif
                        </p>

                @endif
                <div class="more"></div>
            @endforeach

        @endforeach
    @endif



@endsection