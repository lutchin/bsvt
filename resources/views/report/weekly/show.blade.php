<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
    <div class="container add_form_step2 posr">
    	
            <h3 class="title">{{ $report->types->description }} № {{ $report->number }} за период от {{date("d.m.Y",$report->date_start)}} до {{date("d.m.Y",$report->date_end)}}
            	<span>
            		<a target="_blank" href="/{{  $report->types->slug }}/pdf_item/{{ $report->id }}" class="pdf"></a>
            	</span>
            </h3>
		@if( $role != 'user' && $role !='employee' )
        	<span class="pos_tr_article_out status st-{{10 + $report->status}}">
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
        @foreach($items as  $cat => $posts) <?dd($posts)?>
            <div class="row">
                <p class="title title_cat pdf_box">
                	<span>{{ $cat }}</span>
                	<span>
                		<a target="_blank" href="/{{  $report->types->slug }}/pdf_category/{{ $report->id }}/{{$posts->first()->category_id}}" class="pdf"></a>
                	</span>
                </p>
            </div>

                @foreach($posts as  $post)
                    @if(isset($post))
                     <div class="row padl1 out_list_title">
                         <p class="pdf_box">
                            	<span>
                            		<a href="/weekly/article/{{ $post->id }}">
	                            		<strong>{{ $post->title }}</strong>
	                            	</a>
                            	</span>
                            	<span>
                            		<a target="_blank" href="/weekly/pdf_article/{{ $post->id }}" class="pdf"></a>
                            	</span>
	                        <?php
	                        $description = explode(' ', ltrim(html_entity_decode(strip_tags($post->body))));
	                        count($description) <40 ? $count = count($description): $count = 40;
	                        $descrurtion_short = implode(' ', array_slice($description,0, $count));
	                        ?>
							<p style="text-align: justify">
								<span>{{$descrurtion_short}}...</span>
							</p>
						 @if( $role != 'user' && $role !='employee' )
                            	@if($post->published == 0 && $weeklyreport->published!=2)
										<span class="status st-line st-0">| Не утверждено</span>
									@elseif($post->published == 1 && $weeklyreport->published!=2)
										<span class="status st-line st-1">| Ожидает утверждения</span>
									@elseif($post->published == 2 && $weeklyreport->published!=2)
										<span class="status st-line st-2">| Утверждено</span>
                            	@endif
							@endif
                         </p>

                     </div>
                    @endif
                @endforeach
            @endforeach
    @endif

	    <div class="row box_save_article mt30">
            @if(Request::url() == URL::previous())
			    <a href="/analyst/weekly/" class="button butt_back">Все отчеты</a>
			@else
				<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
			@endif
				@if( $role != 'user' && $role !='employee' )
            <a class="button butt_def" href="/analyst/{{  $report->types->slug }}/add2/{{ $report->id }}">Редактировать</a>
				@endif
        </div>
        
    </div>
@endsection
