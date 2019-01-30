<?php $role = Auth::user()->roles[0]->title;?>
<?php
$d = date("d");
$m = date("m");
$y = date("Y");
?>
@extends('layouts.app')

@section('content')
    <div class="container add_form_step2 posr">
        <h3 class="title">
        	Ежегодный справочник "{{ $report->types->description }}" за {{date("Y",$report->date_start)}} год
        	<a target="_blank" href="/{{ $report->types->slug }}/pdf_item/{{ $report->id }}" class="pdf"></a>
        </h3>

		@if( $role != 'user' && $role !='employee' )
		<span class="pos_tr_article_out status st-{{ 10 + $report->status }}">
        	@if($report->status == 2)
        		<span class="status st_inherit">Статус:</span> Опубликован
        	@elseif($report->status == 1)
        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
        	@elseif($report->status == 0)
        		<span class="status st_inherit">Статус:</span> Не опубликован
        		
        	@endif
        </span>
		@endif


		@if(!empty($items))
			@foreach($items as  $region)
			<div class="row out_list_title">
				<p class="title">
					{{ $region->title }}<?dd($region)?>
					<a target="_blank" href="/{{ $report->types->slug }}/pdf_category/{{ $region->id }}" class="pdf"></a>
				</p>
			</div>
				@if(!empty($region->countries))
					<div class="row padl_sub2 out_list_title">
						 <div class="pdf_box">
							<div class="vpor_box">
								<p class="vpor_title">Военно-политическая обстановка в регионе
									@if( $role != 'user' && $role !='employee' )
	                            	@if($region->start == 0 && $report->start !=2)
	                            		<span class="status st-line st-0">| Не утверждено</span>
	                            	@elseif($region->start == 1 && $report->start !=2)
	                            		<span class="status st-line st-1">| Ожидает утверждения</span>
	                            	@elseif($region->start == 2 && $report->start !=2)
	                            		<span class="status st-line st-2">| Утверждено</span>
	                            	@endif
									@endif
								</p>
								
								<div class="vpor_desc" style="display:none;">
									{!!$region->description !!}
									
								</div>
							</div>
	                    </div>
					</div>
					@foreach($region->countries as  $country)

						<div class="row padl_sub1 out_list_title">
							<p class="pdf_box">
                            	<a href="/countrycatalog/article/{{ $country->id }}/{{$report->id}}">
                              		{{ $country->title }}
                            	</a>
                            	<a target="_blank" href="/countrycatalog/pdf_article/{{ $country->id }}" class="pdf"></a>
								<?php
								$description = explode(' ', ltrim(html_entity_decode(strip_tags($country->description))));
								count($description) <40 ? $count = count($description): $count = 40;
								$descrurtion_short = implode(' ', array_slice($description,0, $count));
								?>
								<p style="text-align: justify">
									<span>{{$descrurtion_short}}...</span>
								</p>
							@if( $role != 'user' && $role !='employee' )
                        		@if($country->published == 0 && $countrycatalog->published!=2)
                            		<p class="status st-line st-0">| Не утверждено</p>
                            	@elseif($country->published == 1 && $countrycatalog->published!=2)
                            		<p class="status st-line st-1">| Ожидает утверждения</p>
                            	@elseif($country->published == 2 && $countrycatalog->published!=2)
                            		<p class="status st-line st-2">| Утверждено</p>
                            	@endif
							@endif
                        	</p>
						</div>

					@endforeach
				@endif
			@endforeach
		@endif


    </div>



    <div class="row box_save_article mt30">
        @if(Request::url() == URL::previous())
		    <a href="/analyst/countrycatalog/" class="button butt_back">Все отчеты</a>
		@else
			<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
		@endif
			@if( $role != 'user' && $role !='employee' )
        	<a class="button butt_def" href="/analyst/countrycatalog/add2/{{ $report->id }}">Редактировать</a>
			@endif
    </div>



@endsection






@section('scripts')
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function() {
		jQuery('.vpor_title').on('click',function() {
	
			if(jQuery(this).parent('.vpor_box').hasClass('active')) {
				jQuery(this).parent('.vpor_box').removeClass('active');
				jQuery('.vpor_box .vpor_desc').fadeOut(500);
			} else {
				jQuery(this).parent('.vpor_box').addClass('active');
				jQuery('.vpor_box.active .vpor_desc').fadeIn(500);
			}
			
		})
	})
</script>
@endsection