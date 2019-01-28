<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')

    <div class="container page_create_post">
        <form id="form" action="/analyst/weekly/add3" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <h3>Создание материала для отчета</h3>
                @csrf
                <div class="col-md-12 box_info">
                    <p class="d-flex justify-content-start">
                        <span class="name">Название: </span><span class="text">Бюллетень военно-политической и военно-технической информации за период от {{date("d.m.Y",$weeklyreport->start_date)}} по {{date("d.m.Y",$weeklyreport->end_date)}}</span>
                    </p>
                    <p class="d-flex justify-content-start">
                        <span class="name">Раздел: </span><span class="text">{{ $category->title }}</span>
                    </p>
                    <input type="text" hidden name="category" value="{{ $category->id }}">
                    <input type="text" hidden name="weeklyreport" value="{{ $weeklyreport->id }}">
                    <input type="text" hidden name="year" value="{{ date('Y',$weeklyreport->start_date) }}">
                    <input type="text" hidden name="month" value="{{ date('m',$weeklyreport->start_date) }}">
                </div>

            </div>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Заголовок: </span>
                </div>
                <div class="coll_right">
                    <input type="text" class="title_post" name="title" placeholder="Введите заголовок"/>
                </div>
            </div>
            <div class="row justify-content-start mb_3">
                <div class="coll_left">
                    <span class="name">Материал: </span>
                </div>
                <div class="coll_right">
                    <textarea name="editor1"></textarea>
                </div>
            </div>
            <div class="row justify-content-start mb_3">
                <div class="coll_left">
                    <span class="name">Галерея: </span>
                </div>
                <div class="coll_right d-flex justify-content-between box_add_gallery">
                <?php $count_images = 0; ?>
                    @if(isset($weeklyarticle->weeklyimages))
                        @foreach($weeklyarticle->weeklyimages as $image)
                        	<?php $count_images++; ?>
                          <div class="item_add_gallery item_num_<?php echo $count_images; ?> active">
                              <label class="file_label" for="input_<?php echo $count_images; ?>">
                                <input type="file" id="input_<?php echo $count_images; ?>" value="" class="pic" name="pic[]" data-num="<?php echo $count_images; ?>" placeholder="Нажмите чтобы добавить"/>
                                <input class="reset_img reset_img_<?php echo $count_images; ?>" type="hidden" name="reset_img[]" value=""/>
                                <span><?php echo str_replace( 'article_images/', '', $image->image); ?></span>
                                <img src="/images/{{$image->image}}" class="pic_img num_<?php echo $count_images; ?>" alt=""/>
                                <!-- <b class="del_img_gal">Нажмите, чтобы удалить материал!</b> -->
                              </label>
                              <b class="delete_img" tabindex="0">Удалить</b>
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
                          <span>Нажмите, чтобы добавить изображение</span>
                          <img src="#" class="pic_img num_<?php echo $count_images; ?>" alt=""/>
                        </label>
                        <b class="delete_img" tabindex="0">Удалить</b>
                      </div>
                    <?php
                    }
					        ?>
                </div>
            </div>
            <div class="row box_save_article mt30">
              <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
              {{--<button class="button_save butt butt_def">Сохранить</button>--}}
              <button onclick="jQuery('#form').attr('action','/analyst/weekly/add3'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
            </div>
            <div class="row justify-content-center">
                <h3 class="mb_0">Добавление поисковых меток</h3>
            </div>
            <div class="row name_report name_report_step3 d-flex justify-content-center">
            
	            <div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_left">
	            	
					<span>Период с</span>
		            <span class="select_wrap calendar_wrap" style="display: none;">
			        	<input name="start_period_picker" value="" class="calendar_start_3"/>
			        	<input type="hidden" value="<?php echo $weeklyreport->start_date; ?>" name="start_period">
		        	</span>
		        </div>
		        <div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_right">
		                <span>Период по</span>
		                <span class="select_wrap calendar_wrap" style="display: none;">
				        	<input name="end_period_picker" value="" class="calendar_end_3"/>
				        	<input type="hidden" value="<?php echo $weeklyreport->end_date; ?>" name="end_period">
				        </span>
			    </div>	
		       
            </div>
            
            </br>
            </br>
            </br>
            
            <tags-component></tags-component>
            
            <div class="row box_save_article mt30">
              <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
              {{--<button class="button_save butt butt_def">Сохранить</button>--}}
              <button onclick="jQuery('#form').attr('action','/analyst/weekly/add3'); jQuery('#form').submit(); return false;" class="button_save butt butt_def">Сохранить и отправить на утверждение</button>
            </div>
            
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf-8">
       jQuery(document).ready(function () {
            jQuery('.calendar_start_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$weeklyreport->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$weeklyreport->end_date); ?>',
                value: '<?php echo date("d.m.Y",$weeklyreport->start_date); ?>',
                format: 'dd.mm.yyyy',
            });

            jQuery('.calendar_end_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$weeklyreport->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$weeklyreport->end_date); ?>',
                value: '<?php echo date("d.m.Y",$weeklyreport->end_date); ?>',
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
       })
    </script>
@endsection