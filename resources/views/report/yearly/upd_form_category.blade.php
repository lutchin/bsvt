@extends('layouts.app')

@section('content')

    <div class="container page_create_post">
        <form id="form" action="/analyst/yearly/upd_category/{{$category->id}}" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center posr">
                <h3>Редактирование категории</h3>
                
                <span class="pos_tr_article_out status st-{{$category->published}}">
                	@if($category->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($category->published == 1)
                		<span class="status st_inherit">Статус:</span> Ожидает утверждения
                	@else
                		<span class="status st_inherit">Статус:</span> Утвержден
                	@endif
                </span>
                
                @csrf
                @method('PUT')

            </div>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Категория: </span>
                </div>
                <div class="coll_right">
                    <input type="text" class="title_post" name="title" placeholder="Введите регион" value="{{ $category->title }}"/>
                </div>
            </div>
            
            <div class="row box_save_article mt30">

                @if($category->category)
                    @if($category->published == 0)
                        <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>

                        <button onclick="jQuery('#form').attr('action','/analyst/yearly/upd_subcategory/{{$category->id}}/1'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
                    @elseif($category->published == 1)
                        <a href="/analyst/yearly/add2/{{$category->report}}" class="button butt_back">Вернуться к отчету</a>

                        <button onclick="jQuery('#form').attr('action','/analyst/yearly/upd_subcategory/{{$category->id}}/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
                    @else
                        <a href="/analyst/yearly/add2/{{$category->report}}" class="button butt_back">Вернуться к отчету</a>

                    @endif
                @else
                    @if($category->published == 0)
                        <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>

                        <button onclick="jQuery('#form').attr('action','/analyst/yearly/upd_category/{{$category->id}}/1'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
                    @elseif($category->published == 1)
                        <a href="/analyst/yearly/add2/{{$category->report}}" class="button butt_back">Вернуться к отчету</a>

                        <button onclick="jQuery('#form').attr('action','/analyst/yearly/upd_category/{{$category->id}}/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
                    @else
                        <a href="/analyst/yearly/add2/{{$category->report}}" class="button butt_back">Вернуться к отчету</a>

                    @endif

                @endif
                
            </div>
            
        </form>
        
        {{--@if($category->published == 0)--}}
            {{--<form name="form_1" onsubmit="addApprove(this,'{{$category->title}}');return false;" action="/analyst/countrycatalog/article_for_approval/{{ $category->id }}" method="post">--}}
                {{--{{ method_field('put') }}--}}
                {{--@csrf--}}
            {{--</form>--}}
        {{--@elseif($category->published == 1)--}}
            {{--<form name="form_2" onsubmit="approve(this,'{{$category->title}}');return false;" action="/analyst/countrycatalog/article_publish/{{ $category->id }}" method="post">--}}
                {{--{{ method_field('put') }}--}}
                {{--@csrf--}}
            {{--</form>--}}
        {{--@endif--}}
    </div>
@endsection