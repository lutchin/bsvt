<?php
$d = date("d");
$m = date("m");
$y = date("Y");

$week_end = date('d', strtotime('this week next sunday', mktime(0,0,0,$m,$d,$y)));
$count = cal_days_in_month(CAL_GREGORIAN, $m, $y);
$count_prev = cal_days_in_month(CAL_GREGORIAN, $m-1, $y);
$week_end_count = date('d', strtotime('this week next sunday', mktime(0,0,0,$m,$count,$y)));
function mnames($m) {
	switch ( $m ) {
	    case 1:
	        $m_name = 'января';
	        break;
	    case 2:
	        $m_name = 'февраля';
	        break;
	    case 3:
	        $m_name = 'марта';
	        break;
	    case 4:
	        $m_name = 'апреля';
	        break;
	    case 5:
	        $m_name = 'мая';
	        break;
	    case 6:
	        $m_name = 'июня';
	        break;
	    case 7:
	        $m_name = 'июля';
	        break;
	    case 8:
	        $m_name = 'августа';
	        break;
	    case 9:
	        $m_name = 'сентября';
	        break;
	    case 10:
	        $m_name = 'октября';
	        break;
	    case 11:
	        $m_name = 'ноября';
	        break;
	    case 12:
	        $m_name = 'декабря';
	        break;
	    default:
	        $m      = "Ошибка даты";
	        $m_name = "";
	        break;
	
	}
	return $m_name;
}
?>
@extends('layouts.app')

@section('content')

    <div class="container page_create_post">
        <form action="/analyst/weekly/add3" method="post" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <h3>Создание материала для отчета</h3>
                @csrf
                <div class="col-md-12 box_info">
                    <p class="d-flex justify-content-start">
                        <span class="name">Название: </span><span class="text">Бюллетень военно-политической и военно-технической информации за период от {{ date("d",$weeklyreport->start_date)}} до {{ date("d",$weeklyreport->end_date)}}</span>
                    </p>
                    <p class="d-flex justify-content-start">
                        <span class="name">Раздел: </span><span class="text">{{ $category->title }}</span>
                    </p>
                    <input type="text" hidden name="category" value="{{ $category->id }}">
                    <input type="text" hidden name="weeklyreport" value="{{ $weeklyreport->id }}">
                    <input type="text" hidden name="year" value="<?= $y?>">
                    <input type="text" hidden name="month" value="<?= $m?>">
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
            <div class="box_save_article">
                <button class="button_save">Сохранить</button>
            </div>
            <div class="row justify-content-center">
                <h3 class="mb_0">Добавление поисковых меток</h3>
            </div>
            <div class="row name_report name_report_step3 d-flex justify-content-center">
            	<div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_left">
					<span>Период с</span>
		            <span class="select_wrap">
							<select name="start_period" id="" class="start_period data_def select_bg_none">
					        	<?php
						        	$w1 = date("W", mktime(0, 0, 0, $m-1,$count_prev,$y));
									
			                        for ( $i = date("d",$weeklyreport->start_date); $i <= date("d",$weeklyreport->end_date); $i++ ) {
			                        	$w_curr = date("W", mktime(0, 0, 0, $m,$i,$y));
										
										$d_end = (int)date('d', strtotime('this week next sunday', mktime(0,0,0,$m,$i-1,$y)));
										if($d_end < $i) $d_end = 0;
			                        	$w2 = date("W", mktime(0, 0, 0, $m,$i,$y));
										if($w2 == $w1) continue;
										
			                            if ( $i == $d ) {
			                                echo "<option data-week ='$w_curr' data-day-end ='$d_end' selected value='".mktime(0,0,0,$m,$i,$y)."'>$i ".mnames($m)." ".$y." года</option>";
			                            }
			                            else {
			                                echo "<option data-week ='$w_curr' data-day-end ='$d_end' value='".mktime(0,0,0,$m,$i,$y)."'>$i ".mnames($m)." ".$y." года</option>";
			                            }
			                        }
		                        ?>
				        	</select>
			        	</span>
		        	</div>
		        	<div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_right">
		                <span>Период по</span>
		                <span class="select_wrap">
				        	<select name="end_period" id="" class="end_period data_def">
				        		<?php
				        		
                               		$w1 = date("W", mktime(0, 0, 0, $m,$count,$y));
						
			                        for ( $i = date("d",$weeklyreport->start_date); $i <= date("d",$weeklyreport->end_date); $i++ ) {
			                        	
			                        	$w_curr = date("W", mktime(0, 0, 0, $m,$i,$y));
										
			                            if($i > $count) {
											if($m == 12 || $m == 0) {
			                            		$y_cur = date("Y") + 1;
												$y = $y_cur;
												$m = 0;
			                            	}
											
			                        		$w2 = date("W", mktime(0, 0, 0, $m+1,$i%$count,$y));
			                        		
											if($m == 12 || $m == 0) {
			                            		if($w2 == 2)  break;
			                            	} else {
			                            		if($w2 > $w1)  break;
			                            	}
											
											
			                            	if(($i == ($week_end_count + $count)) && $week_end < $d) {
												echo "<option data-week ='$w_curr' data-day-end ='$i' SELECTED value='".mktime(0,0,0,$m+1,$i%$count,$y)."'>".$i%$count." ".mnames($m+1)." ".$y." года</option>";
											} else {
												echo "<option data-week ='$w_curr' data-day-end ='$i' value='".mktime(0,0,0,$m+1,$i%$count,$y)."'>".$i%$count." ".mnames($m+1)." ".$y." года</option>";	
											}
										} else {
											if($week_end >= $d && $i == $week_end) {
												echo "<option data-week ='$w_curr' data-day-end ='$i' selected value='".mktime(0,0,0,$m,$i,$y)."'>".$i." ".mnames($m)." ".$y." года</option>";
											}
											else {
												echo "<option data-week ='$w_curr' data-day-end ='$i' value='".mktime(0,0,0,$m,$i,$y)."'>".$i." ".mnames($m)." ".$y." года</option>";
											}
											
											
											
										}
			
			                        }
		                        ?>
				        	</select>
				        </span>
			       </div>
            </div>
            </br>
            </br>
            </br>
            <tags-component></tags-component>
            <div class="box_save_article">
                <button class="button_save">Сохранить</button>
            </div>
        </form>
    </div>
@endsection