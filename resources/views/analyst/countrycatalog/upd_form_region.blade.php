@extends('layouts.app')

@section('content')

    <div class="container page_create_post">
        <form id="form" action="/analyst/countrycatalog/updregion/{{$region->id}}/{{$countrycatalog}}" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center posr">
                <h3>Редактирование региона</h3>
                
                <span class="pos_tr_article_out status st-{{$region->published}}">
                	@if($region->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($region->published == 1)
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
                    <span class="name">Регион: </span>
                </div>
                <div class="coll_right">
                    <input type="text" class="title_post" name="title" placeholder="Введите регион" value="{{ $region->title }}"/>
                </div>
            </div>
            <div class="row justify-content-start mb_3">
                <div class="coll_left">
                    <span class="name">Описание: </span>
                </div>
                <div class="coll_right">
                    <textarea name="editor1">{{ $region->overview }}</textarea>
                </div>
            </div>
            
            <div class="row box_save_article mt30">
            	
                
                @if($region->published == 0)
                	<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>

	            	<button onclick="jQuery('#form').attr('action','/analyst/countrycatalog/updregion/{{$region->id}}/{{$countrycatalog}}/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и и утвердить</button>
	        	@elseif($region->published == 1)
	        		<a href="/analyst/countrycatalog/add2/{{$countrycatalog}}" class="button butt_back">Вернуться к отчету</a>

	                <button onclick="jQuery('#form').attr('action','/analyst/countrycatalog/updregion/{{$region->id}}/{{$countrycatalog}}/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
	        	@else
	        		<a href="/analyst/countrycatalog/add2/{{$countrycatalog}}" class="button butt_back">Вернуться к отчету</a>
                    <button onclick="jQuery('#form').attr('action','/analyst/countrycatalog/updregion/{{$region->id}}/{{$countrycatalog}}/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
	        	@endif
                
            </div>
            
        </form>
        
        @if($region->published == 0)
            <form name="form_1" onsubmit="addApprove(this,'{{$region->title}}');return false;" action="/analyst/countrycatalog/article_for_approval/{{ $region->id }}" method="post">
                {{ method_field('put') }}
                @csrf
            </form>
        @elseif($region->published == 1)
            <form name="form_2" onsubmit="approve(this,'{{$region->title}}');return false;" action="/analyst/countrycatalog/article_publish/{{ $region->id }}" method="post">
                {{ method_field('put') }}
                @csrf
            </form>
        @endif
    </div>
@endsection