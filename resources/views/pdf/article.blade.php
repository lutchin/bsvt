@extends('layouts.pdf')

@section('content')
    <!-- <div class="pdf_wrap"> -->
        <h1 class="pdf_title"> {{ $title }} </h1>
        <!-- <div class="row cat"> -->
            <h3 class="title title_cat">
                {{ $article->category->title }}
            </h3>
            @if(isset($article->subcategory))
            <h3 style="text-align: center; margin-top: -10px">{{ $article->subcategory->title }}</h3>
            @endif
        <!-- </div> -->

        @if(isset($article->title))
            <h3 class="title" style="text-align: center;">{{ $article->title }}</h3>
        @endif
        <!-- <br> -->

        <p>{!!   $article->description !!}</p>
        {!!   $article->description !!}

        <p class="pdf_gallery">
            @if(isset($article->images))
                @foreach($article->images as $image)
                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                @endforeach
            @endif
        </p>
    <!-- </div> -->
@endsection