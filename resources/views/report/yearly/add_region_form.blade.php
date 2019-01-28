<?php
$d = date("d");
$m = date("m");
$y = date("Y");

$count = cal_days_in_month(CAL_GREGORIAN, $m, $y);

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
?>
@extends('layouts.app')

@section('nav_header_other', '')

@section('content')

    <div class="container page_create_post">
        <p class="d-flex justify-content-start">
            <span class="name">Название: </span><span class="text">ЕЖЕГОДНЫЙ СПРАВОЧНИК ПО ИНОСТРАННЫМ ГОСУДАРСТВАМ за период от {{ date("d",$countrycatalog->start_date)}} до {{ date("d",$countrycatalog->end_date)}}</span>
        </p>
        <form action="/analyst/countrycatalog/addregion" method="post" >
            <div class="row justify-content-center">
                <h3>Добавление региона</h3>
                @csrf
                <div class="col-md-12 box_info">

                    <input type="text" hidden name="countrycatalog" value="{{ $countrycatalog->id }}">
                    <input type="text" hidden name="year" value="<?= $y?>">
                    <input type="text" hidden name="month" value="<?= $m?>">
                </div>

            </div>
            <div class="row justify-content-start mb-3">
                <div class="coll_left">
                    <span class="name">Заголовок региона: </span>
                </div>
                <div class="coll_right">
                    <input type="text" class="title_post" name="title" placeholder="Введите заголовок"/>
                </div>
            </div>
            <div class="row justify-content-start mb_3">
                <div class="coll_left">
                    <span class="name">Военно-политическая обстановка в регионе: </span>
                </div>
                <div class="coll_right">
                    <textarea name="editor1"></textarea>
                </div>
            </div>
            <div class="row name_report name_report_step3 d-flex justify-content-center">
                <div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_left">
                    <span>Период с</span>
                    <span class="select_wrap">
							<select name="start_period" id="" class="data_def">
					        	<?php
                                for ( $i = date("d",$countrycatalog->start_date); $i <= date("d",$countrycatalog->end_date); $i++ ) {
                                    if ( $i == date("d",$countrycatalog->start_date)) {
                                        echo "<option selected value='".mktime(0,0,0,$m,$i,$y)."'>$i $m_name</option>";
                                    }
                                    else {
                                        echo "<option value='".mktime(0,0,0,$m,$i,$y)."'>$i $m_name</option>";
                                    }
                                }
                                ?>
				        	</select>
			        	</span>
                </div>
                <div class="col-md-4 float_left d-flex  flex-column justify-content-center align-items-start box_right">
                    <span>Период по</span>
                    <span class="select_wrap">
				        	<select name="end_period" id="" class="data_def">
				        		<?php
                                for ( $i = date("d",$countrycatalog->start_date); $i <= date("d",$countrycatalog->end_date); $i++ ) {
                                    if ( $i == date("d",$countrycatalog->end_date)) {
                                        echo "<option selected value='".mktime(0,0,0,$m,$i,$y)."'>$i $m_name</option>";
                                    }
                                    else {
                                        echo "<option value='".mktime(0,0,0,$m,$i,$y)."'>$i $m_name</option>";
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
            <div class="row justify-content-center">
                <button class="button_save">Сохранить</button>
            </div>
        </form>
    </div>
@endsection