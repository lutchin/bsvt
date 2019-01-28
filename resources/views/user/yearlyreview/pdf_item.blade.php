@extends('layouts.pdf')

@section('content')
    <h3 style="text-align: center">{{ $reporttitle }}<!-- № {{ $number }}-->  за {{ date("Y",$article->start_date)}} год</h3>
    @foreach($report as $category)
    <h3 style="text-align: center"> {{ $category->title }}</h3>
    @if(isset($category->body))
    <p>{!!   $category->body !!}</p>
    <p class="pdf_gallery">
        @if(isset($category->images))
            @foreach($category->images as $image)
                <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
            @endforeach
        @endif
    </p>
    <br>
    @endif
        @if(isset($category->articles))
            @foreach($category->articles as $article)

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
                <br>
            @endforeach

        @endif
    @if($category->subcategories)
        @foreach($category->subcategories as $subcategory)
             <h3 style="text-align: center">{{ $subcategory->title }}</h3>
            @foreach($subcategory->articles as $article)


                @if(isset($article->title))
                    <h3 style="text-align: center" class="title">{{ $article->title }}</h3>
                @endif

                <p>{!!   $article->body !!}</p>
                <p class="pdf_gallery">
                    @if(isset($article->images))
                        @foreach($article->images as $image)
                            <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                        @endforeach
                    @endif
                </p>
                <br>
            @endforeach

        @endforeach
    @endif
    @endforeach

@endsection