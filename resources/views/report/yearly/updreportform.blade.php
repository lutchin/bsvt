<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')
    <div class="container add_form_step1">
        <div class="row justify-content-center">
            <h3 class="title">Редактирование отчета</h3>
        </div>
        <form action="/analyst/yearly/updreport/{{$yearlyreport->id}}" method="post">
            @csrf
            <input type="text" hidden name="year" value="<?= $y?>">
            <input type="text" hidden name="month" value="<?= $m?>">
            <div class="row name_report">
                <span>"{{$reporttitle}}" за период от</span>
                <span class="select_wrap calendar_wrap" style="display: none;">
		        	<input name="start_period_picker" value="" class="calendar_start_3"/>
		        	<input type="hidden" value="<?php echo mktime(0,0,0,$m,$d,$y); ?>" name="start_period">
	        	</span>
                <span>&nbsp;до&nbsp;</span>
                <span class="select_wrap calendar_wrap" style="display: none;">
		        	<input name="end_period_picker" value="" class="calendar_end_3"/>
		        	<input type="hidden" value="<?php echo mktime(0,0,0,$m,$d,$y); ?>" name="end_period">
		        </span><br>
		        {{--<span>&nbsp;номер отчета&nbsp;</span>--}}
                {{--<span>--}}
		        	{{--<input name="number" value="{{ $yearlyreport->number }}" placeholder="№"/>--}}
		        {{--</span>--}}
            </div>
            <div class="row justify-content-center">
                <button class="butt butt_mt_2 butt_def">Сохранить</button>
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
                minDate: '<?php echo date("d.m.Y",$yearlyreport->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$yearlyreport->end_date); ?>',
                value: '<?php echo date("d.m.Y",$yearlyreport->start_date); ?>',
                format: 'dd.mm.yyyy',
            });

            jQuery('.calendar_end_3').datepicker({
                keyboardNavigation: true,
                modal: true,
                header: true,
                footer: true,
                uiLibrary: 'bootstrap4',
                locale: 'ru-ru',
                minDate: '<?php echo date("d.m.Y",$yearlyreport->start_date); ?>',
                maxDate: '<?php echo date("d.m.Y",$yearlyreport->end_date); ?>',
                value: '<?php echo date("d.m.Y",$yearlyreport->end_date); ?>',
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