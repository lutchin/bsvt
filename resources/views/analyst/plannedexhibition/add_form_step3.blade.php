<?php
$d = date("d");
$m = date("m");
$y = date("Y");


?>
@extends('layouts.app')

@section('content')
<div class="container page_create_post">
    <form action="/analyst/plannedexhibition/add3" method="post" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <h3>Ежегодный календарь "Перечень международных выставок вооружений и военной техники, планируемых к проведению в иностранных государствах"</h3>
            @csrf
            <input type="text" hidden name="year" value="<?= $y?>">
            <input type="text" hidden name="month" value="<?= $m?>">
            <input type="text" hidden name="plannedexhibitionyear" value="{{ $plannedexhibitionyear->id }}">

        </div>
        <div class="row justify-content-start mb-3">
            <div class="coll_left">
                <span class="name">Название: </span>
            </div>
            <div class="coll_right">
                <textarea type="text" class="title_post" name="title" placeholder="Введите название выставки"></textarea>
            </div>
        </div>
        {{--<div class="row justify-content-start mb-3">--}}
            {{--<div class="coll_left">--}}
                {{--<span class="name">Регион: </span>--}}
            {{--</div>--}}
            {{--<div class="coll_right">--}}
                {{--<input type="text" class="title_post" name="region" placeholder="Введите регион"/>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="row justify-content-start mb-3">--}}
            {{--<div class="coll_left">--}}
                {{--<span class="name">Страна: </span>--}}
            {{--</div>--}}
            {{--<div class="coll_right">--}}
                {{--<input type="text" class="title_post" name="country" placeholder="Введите страну"/>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="row justify-content-start mb-3">
            <div class="coll_left">
                <span class="name">Место: </span>
            </div>
            <div class="coll_right">
                <textarea class="title_post" name="place" placeholder="Введите место проведения"></textarea>
            </div>
        </div>
        <div class="row justify-content-start mb-3">

            <p class="name date_name">
                <span>Дата: с</span>
                <span class="select_wrap calendar_wrap" style="display: none;">
			        	<input name="start_period_picker" value="" class="calendar_start_3"/>
			        	<input type="hidden" value="<?php echo mktime(0,0,0,$m,$d,$y); ?>" name="start_period">
		        	</span>
                <span> по </span>
                <span class="select_wrap calendar_wrap" style="display: none;">
			        	<input name="end_period_picker" value="" class="calendar_end_3"/>
			        	<input type="hidden" value="<?php echo mktime(0,0,0,12,31,$y); ?>" name="end_period">
			    </span>
            </p>

        </div>
        <br>
        <div class="row justify-content-start mb-3">
            <div class="coll_left">
                <span class="name">Тематика: </span>
            </div>
            <div class="coll_right">
                <textarea name="theme"></textarea>
            </div>
        </div>
        {{--<div class="row justify-content-start mb_3">--}}
            {{--<div class="coll_left">--}}
                {{--<span class="name">Описание: </span>--}}
            {{--</div>--}}
            {{--<div class="coll_right">--}}
                {{--<textarea name="editor1"></textarea>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="row justify-content-start mb_3">
            <div class="coll_left">
                <span class="name">Материалы: </span>
            </div>
            <div class="coll_right d-flex justify-content-between box_add_gallery">
            <?php $count_images = 0; ?>
                    @if(isset($plannedexhibition->images))
                        @foreach($plannedexhibition->images as $image)
                        	<?php $count_images++; ?>
                          <div class="item_add_gallery item_num_<?php echo $count_images; ?> active">
                              <label class="file_label" for="input_<?php echo $count_images; ?>">
                                <input type="file" id="input_<?php echo $count_images; ?>" value="" class="pic" name="pic[]" data-num="<?php echo $count_images; ?>" placeholder="Нажмите чтобы добавить"/>
                                <input class="reset_img reset_img_<?php echo $count_images; ?>" type="hidden" name="reset_img[]" value=""/>
                                <span><?php echo str_replace( 'article_images/', '', $image->image); ?></span>
                                <img src="/images/{{$image->image}}" class="pic_img num_<?php echo $count_images; ?>" alt=""/>
                                <!-- <b class="del_img_gal">Нажмите, чтобы удалить материал!</b> -->
                              </label>
                              <b class="delete_content" tabindex="0">Удалить</b>
                            </div>
                        @endforeach
                    @endif
                    <?php $count_for = $count_images; ?>
                    <?php for($i=0; $i< (3 - $count_for); $i++) {
                    	$count_images++;
                     ?>
                      <div class="item_add_gallery item_num_<?php echo $count_images; ?>">
                        <label class="file_label" for="input_<?php echo $count_images; ?>">
                          <input type="file" id="input_<?php echo $count_images; ?>" class="pic" name="pic[]" data-num="<?php echo $count_images; ?>" placeholder="Нажмите чтобы добавить"/>
                          <span>Нажмите, чтобы добавить материал</span>
                          <img src="#" class="pic_img num_<?php echo $count_images; ?>" alt=""/>
                        </label>
                        <b class="delete_content" tabindex="0">Удалить</b>
                      </div>
                    <?php
                    }
					      ?>
            </div>
        </div>
        <div class="row box_save_article mt30">
              <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
              {{--<button class="button_save butt butt_def">Сохранить</button>--}}
              <button onclick="submit()" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
        </div>
        <div class="row justify-content-center">
            <h3 class="mb_0">Добавление поисковых меток</h3>
        </div>
        <tags-component></tags-component>
        
		    <div class="row box_save_article mt30">
              <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
              {{--<button class="button_save butt butt_def">Сохранить</button>--}}
              <button onclick="submit()" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
        </div>
        
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf-8">
        function submit(){
            jQuery('#form').attr('action','/analyst/plannedexhibition/add3/1'); jQuery('#form').submit(); return false;
        }
    	jQuery(document).ready(function () {
            
            jQuery('.calendar_start_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->end_date); ?>',
                value: '<?php echo date("d.m.Y",$plannedexhibitionyear->start_date); ?>',
                format: 'dd.mm.yyyy',
            });

            jQuery('.calendar_end_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->end_date); ?>',
                value: '<?php echo date("d.m.Y",$plannedexhibitionyear->end_date); ?>',
                format: 'dd.mm.yyyy',

            });
            
            jQuery('.calendar_start_3').change(function() {	
            	
            	jQuery('.calendar_wrap').removeClass('error');
            	
				var data_change = jQuery(this).val();
				var arr = data_change.split('.');
        		var d = Number(arr[0]) + 1;
				var m = Number(arr[1]) - 1;
				var y = Number(arr[2]);
        		var date = new Date(y,m,d).getTime()/1000;
        		jQuery('[name=start_period]').val(date);
        	})
        	
			jQuery('.calendar_end_3').change(function() {	
				
				jQuery('.calendar_wrap').removeClass('error');
				
				var data_change = jQuery(this).val();
				var arr = data_change.split('.');
				var d = Number(arr[0]) + 1;
				var m = Number(arr[1]) - 1;
				var y = Number(arr[2]);
        		var date = new Date(y,m,d).getTime()/1000;
        		jQuery('[name=end_period]').val(date);
        	})

            jQuery('.calendar_wrap').show(500);
            
            if(jQuery('[name=theme]').length) {
                CKEDITOR.replace('theme');
            }
            if(jQuery('[name=place]').length) {
                CKEDITOR.replace('place');
            }
            if(jQuery('[name=title]').length) {
                CKEDITOR.replace('title');
            }
       })
    </script>
@endsection