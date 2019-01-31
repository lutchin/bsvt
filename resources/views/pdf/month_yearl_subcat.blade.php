@extends('layouts.pdf')

@section('content')
    <h3 class="title" style="text-align: center">{{ $report->types->title }} ({{ Helper::getMonthText(date('m', $report->date_start)) }} {{ date('Y', $report->date_start) }})</h3>
    @foreach($report_array as  $cat =>$item)
        @if($cat != 'false')
            <h3 class="title title_cat" style="text-align: center">
                <strong>{{ $cat }}</strong>
            </h3>
            @foreach($item as  $key =>$value)
                @if($key !== 'false')
                    <div class="row">
                        <h3 class="title padl_sub1 title_sub_cat" style="text-align: center">
                            <strong>{{ $key }}</strong>
                        </h3>
                    </div>
                @endif
                @foreach($value as  $k =>$v)
                    @if(isset($v))
                        <h3 style="text-align: center;">
                            <strong>{{ $v->title }}</strong></h3>
                        <p>
                            {!! $v->description !!}
                        </p>
                        <p class="pdf_gallery">
                            @if(isset($v->images))
                                @foreach($v->images as $image)
                                    <img style="margin-bottom: 30px; max-height: 940px" src="images/{{$image->image}}">
                                @endforeach
                            @endif
                        </p>
                        <div class="more"></div>
                    @endif
                @endforeach
            @endforeach
        @endif
    @endforeach
@endsection
