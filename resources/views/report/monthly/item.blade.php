<?php $role = Auth::user()->roles[0]->title;?>
<?php

function getMonthText($m) {
	switch ( $m ) {
	    case 1:
	        $m_name = 'январь';
	        break;
	    case 2:
	        $m_name = 'февраль';
	        break;
	    case 3:
	        $m_name = 'март';
	        break;
	    case 4:
	        $m_name = 'апрель';
	        break;
	    case 5:
	        $m_name = 'май';
	        break;
	    case 6:
	        $m_name = 'июнь';
	        break;
	    case 7:
	        $m_name = 'июль';
	        break;
	    case 8:
	        $m_name = 'август';
	        break;
	    case 9:
	        $m_name = 'сентябрь';
	        break;
	    case 10:
	        $m_name = 'октябрь';
	        break;
	    case 11:
	        $m_name = 'ноябрь';
	        break;
	    case 12:
	        $m_name = 'декабрь';
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
    <div class="container add_form_step2 posr">
    	
    	<h3 class="title">{{$reporttitle}} № {{ $monthlyreport->number }} ({{ getMonthText(date('m', $monthlyreport->start_date)) }} {{ date('Y', $monthlyreport->start_date) }})
    		<span>
				<a target="_blank" href="/monthly/pdf_item/{{ $monthlyreport->id }}" class="pdf"></a>
			</span>
    	</h3>
		@if( $role != 'user' && $role !='employee' )
        <span class="pos_tr_article_out status st-{{10 + $monthlyreport->published}}">
	    	@if($monthlyreport->published == 2)
	    		<span class="status st_inherit">Статус:</span> Опубликован
	    	@elseif($monthlyreport->published == 1)
	    		<span class="status st_inherit">Статус:</span> Все материалы утверждены
	    	@elseif($monthlyreport->published == 0)
	    		<span class="status st_inherit">Статус:</span> Не опубликован
	    		
	    	@endif
	    </span>
		@endif
                <?php $n1 = 0; $n2 = 0; $n3 = 0; ?>
                @foreach($items as  $cat =>$item)
                    @if($cat != 'false')
                    <?php $n1++; ?>
                	<div class="row">
                    	<p class="title title_cat">
                        	{{ $n1 }}. {{ $cat }}
                        	<span>
	                            <a target="_blank" href="/monthly/pdf_category/{{ $monthlyreport->id }}/{{ \App\Category::where('title',$cat)->first()->id }}" class="pdf"></a>
	                        </span>
			            </p>
			   		</div>
			   		
                        @foreach($item as  $key =>$value)
                            @if($key !== 'false')
                            <?php $n2++; ?>
								<div class="row">
                    				<p class="title padl_sub1 title_sub_cat">
										{{ $n1 }}.{{ $n2 }}. {{ $key }}
										<span>
		                                    <a target="_blank" href="/monthly/pdf_subcategory/{{ $monthlyreport->id }}/{{ \App\Category::where('title',$cat)->first()->id }}/{{ \App\Subcategory::where('title',$key)->first()->id }}" class="pdf"></a>
		                                </span>
									</p>
								</div>
                            @endif
                            @foreach($value as  $k =>$v)
                                @if(isset($v))
                                <?php $n3++; ?>
                                <div class="row padl_sub2 out_list_title">
                                    <p class="pdf_box">
                                    	<span>
	                                        <a href="/monthly/article/{{ $v->id }}">
	
	                                            <p>  {{ $n1 }}.{{ $n2 }}.{{ $n3 }}. {{ $v->title }}</p>
	                                        </a>
	                                    </span>
		                            	<span>
		                            		<a target="_blank" href="/monthly/pdf_article/{{ $v->id }}" class="pdf"></a>
		                            	</span>
										<?php
										$description = explode(' ', ltrim(html_entity_decode(strip_tags($v->body))));
										count($description) <40 ? $count = count($description): $count = 40;
										$descrurtion_short = implode(' ', array_slice($description,0, $count));
										?>
										<p style="text-align: justify">
											<span>{{$descrurtion_short}}...</span>
										</p>
									@if( $role != 'user' && $role !='employee' )
		                            	@if($v->published == 0 && $monthlyreport->published!=2)
		                            		<p class="status st-line st-0">| Не утверждено</p>
		                            	@elseif($v->published == 1 && $monthlyreport->published!=2)
		                            		<p class="status st-line st-1">| Ожидает утверждения</p>
		                            	@elseif($v->published == 2 && $monthlyreport->published!=2)
		                            		<p class="status st-line st-2">| Утверждено</p>
		                            	@endif
									@endif
                                 </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
                
                <div class="row box_save_article mt30">
		            
		           	@if(Request::url() == URL::previous())
					    <a href="/analyst/monthly/" class="button butt_back">Все отчеты</a>
					@else
						<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
					@endif
						@if( $role != 'user' && $role !='employee' )
		           	<a class="button butt_def" href="/analyst/monthly/add2/{{ $monthlyreport->id }}">Редактировать</a>
						@endif
		        </div>
	    
    </div>
@endsection
