<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')

    <div class="container page_create_post">
        <form id="form" action="/analyst/plannedexhibition/upd" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center posr">
                
                <h3>Информационно-справочные материалы к выставкам вооружений</h3>
                
                <span class="pos_tr_article_out status st-{{$plannedexhibition->published}}">
                	@if($plannedexhibition->published == 0)
                		<span class="status st_inherit">Статус:</span> Не утвержден
                	@elseif($plannedexhibition->published == 1)
                		<span class="status st_inherit">Статус:</span> Ожидает утверждения
                	@else
                		<span class="status st_inherit">Статус:</span> Утвержден
                	@endif
                </span>
                
                @csrf
                @method('PUT')
                <input type="text" hidden name="year" value="<?= $y?>">
                <input type="text" hidden name="month" value="<?= $m?>">
                <input type="text" hidden name="exhibition" value="{{$plannedexhibition->id}}">
                <input type="text" hidden name="plannedexhibitionyear" value="{{$plannedexhibitionyear->id}}">
            </div>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Название: </span>
                </div>
                <div class="coll_right">
                    <textarea class="title_post" name="title" placeholder="Введите название материала">{{$plannedexhibition->title}}</textarea>
                </div>
            </div>
            <div class="row justify-content-start mb-3">

                <p class="name date_name">
                    <span>Дата: с</span>
                    <span class="select_wrap calendar_wrap" style="display: none;">
				        <input name="start_period_picker" value="" class="calendar_start_3"/>
				        <input type="hidden" value="{{$plannedexhibition->start}}" name="start">
			        </span>
                    <span> по </span>
                    <span class="select_wrap calendar_wrap" style="display: none;">
				        <input name="end_period_picker" value="" class="calendar_end_3"/>
				        <input type="hidden" value="{{$plannedexhibition->fin}}" name="fin">
				     </span>
                </p>

            </div>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Место: </span>
                </div>
                <div class="coll_right">
                    <textarea class="title_post" name="place" placeholder="Введите место проведения">{{$plannedexhibition->place}}</textarea>
                </div>
            </div>
            <br>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Тематика: </span>
                </div>
                <div class="coll_right">
                    <textarea name="theme">{{$plannedexhibition->theme}}</textarea>
                </div>
            </div>
            {{--<div class="row justify-content-start mb_3">--}}
                {{--<div class="coll_left">--}}
                    {{--<span class="name">Описание: </span>--}}
                {{--</div>--}}
                {{--<div class="coll_right">--}}
                    {{--<textarea name="editor1">{{$plannedexhibition->description}}</textarea>--}}
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
            	                
                @if($plannedexhibition->published == 0)
                	<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                	{{--<button class="button_save butt butt_def">Сохранить</button>--}}
	            	<button onclick="jQuery('#form').attr('action','/analyst/plannedexhibition/upd/1'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
                @elseif($plannedexhibition->published == 1)
                  <a href="/analyst/plannedexhibition/add2/{{$plannedexhibitionyear->id}}" class="button butt_back">Вернуться к отчету</a>
                      {{--<button class="button_save butt butt_def">Сохранить</button>--}}
                      <button onclick="jQuery('#form').attr('action','/analyst/plannedexhibition/upd/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
                @else
                  <a href="/analyst/plannedexhibition/add2/{{$plannedexhibitionyear->id}}" class="button butt_back">Вернуться к отчету</a>
                  <button class="button_save butt butt_def">Сохранить</button>
                @endif
                
            </div>
            <div class="row justify-content-center">
                <h3 class="mb_0">Добавление поисковых меток</h3>
            </div>
            <tags-component :selectedtags="{{json_encode($tags)}}"></tags-component>
            
            <div class="row box_save_article mt30">
            	                
                @if($plannedexhibition->published == 0)
                	<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                	{{--<button class="button_save butt butt_def">Сохранить</button>--}}
	            	<button onclick="jQuery('#form').attr('action','/analyst/plannedexhibition/upd/1'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
	        	@elseif($plannedexhibition->published == 1)
	        		<a href="/analyst/plannedexhibition/add2/{{$plannedexhibitionyear->id}}" class="button butt_back">Вернуться к отчету</a>
	                {{--<button class="button_save butt butt_def">Сохранить</button>--}}
	                <button onclick="jQuery('#form').attr('action','/analyst/plannedexhibition/upd/2'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и утвердить</button>
	        	@else
	        		<a href="/analyst/plannedexhibition/add2/{{$plannedexhibitionyear->id}}" class="button butt_back">Вернуться к отчету</a>
	        		<button class="button_save butt butt_def">Сохранить</button>
	        	@endif
                
            </div>
            
        </form>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function () {

          // DELETE FILE
          var file = jQuery('.reset_img');
          var file_data = file.attr('data-del');
          // var files = jQuery('[name="pic"]');
            jQuery('.del_matherials').on('click', function() {
              file.val(file_data);
          })
          // END DELETE FILE
        	
        	if(jQuery('[name=theme]').length) {
                CKEDITOR.replace('theme');
            }
            if(jQuery('[name=event_general_information]').length) {
                CKEDITOR.replace('event_general_information');
            }
            if(jQuery('[name=participants]').length) {
                CKEDITOR.replace('participants');
            }
            if(jQuery('[name=results]').length) {
                CKEDITOR.replace('results');
            }
            if(jQuery('[name=military_situation]').length) {
                CKEDITOR.replace('military_situation');
            }
            if(jQuery('[name=country_general_information]').length) {
                CKEDITOR.replace('country_general_information');
            }
            if(jQuery('[name=general_tender]').length) {
                CKEDITOR.replace('general_tender');
            }
            if(jQuery('[name=vvt]').length) {
                CKEDITOR.replace('vvt');
            }
            if(jQuery('[name=features_of_stay]').length) {
                CKEDITOR.replace('features_of_stay');
            }
            
            jQuery('.calendar_start_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$plannedexhibitionyear->end_date); ?>',
                value: '<?php echo date("d.m.Y",$plannedexhibition->start); ?>',
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
                value: '<?php echo date("d.m.Y",$plannedexhibition->fin); ?>',
                format: 'dd.mm.yyyy',

            });
			
			jQuery('.calendar_start_3').change(function() {	
				
				jQuery('.calendar_wrap').removeClass('error');
				
				var data_change = jQuery(this).val();
				var arr = data_change.split('.');
        		var d = Number(arr[0]);
				var m = Number(arr[1]) - 1;
				var y = Number(arr[2]);
        		var date = new Date(y,m,d).getTime()/1000;
        		jQuery('[name=start]').val(date);
        	})
        	
			jQuery('.calendar_end_3').change(function() {	
				
				jQuery('.calendar_wrap').removeClass('error');
				
				var data_change = jQuery(this).val();
				var arr = data_change.split('.');
				var d = Number(arr[0]);
				var m = Number(arr[1]) - 1;
				var y = Number(arr[2]);
        		var date = new Date(y,m,d).getTime()/1000;
        		jQuery('[name=fin]').val(date);
        	})
        	

            jQuery('.calendar_wrap').show(500);
            if(jQuery('[name=place]').length) {
                CKEDITOR.replace('place');
            }
            if(jQuery('[name=title]').length) {
                CKEDITOR.replace('title');
            }
           	
        });
    </script>
@endsection