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
        	Ежегодный справочник "{{ $reporttitle }}" <!--№ {{ $yearlyreport->number }}--> за {{date("Y",$yearlyreport->start_date)}} год
        	<span>
	            <a target="_blank" href="/yearly/pdf_item/{{ $yearlyreport->id }}" class="pdf"></a>
	        </span>
        </h3>
		@if( $role != 'user' && $role !='employee' )
		<span class="pos_tr_article_out status st-{{10 + $yearlyreport->published}}">
        	@if($yearlyreport->published == 2)
        		<span class="status st_inherit">Статус:</span> Опубликован
        	@elseif($yearlyreport->published == 1)
        		<span class="status st_inherit">Статус:</span> Все материалы утверждены
        	@elseif($yearlyreport->published == 0)
        		<span class="status st_inherit">Статус:</span> Не опубликован
        		
        	@endif
        </span>
		@endif
        @if(!empty($items))
            @foreach($items as  $report)
				@if(!empty($report->articlesReport))
					@foreach($report->articlesReport as  $article)
						<div class="row padl_sub2 out_list_title">
							<p class="pdf_box">
								<a href="/yearly/article/{{ $article->id }}">
									<strong>{{ $article->title }}</strong>
								</a>
								<a target="_blank" href="/yearly/pdf_article/{{ $article->id }}" class="pdf"></a>
							</p>
						    <?php
						    $description = explode(' ', ltrim(html_entity_decode(strip_tags($article->body))));
						    count($description) <40 ? $count = count($description): $count = 40;
						    $descrurtion_short = implode(' ', array_slice($description,0, $count));
						    ?>
							<p style="text-align: justify">
								<span>{{$descrurtion_short}}...</span>
							</p>
						</div>
					@endforeach
				@endif
                @if(!empty($report->categories))
                    @foreach($report->categories as  $category)
                        <div class="row out_list_title mt10">
                            <p class="title">
                            	{{ $category->title }}
                            	<span>
                                    <a target="_blank" href="/yearly/pdf_category/{{ $category->id }}" class="pdf"></a>
                                </span>
                            </p>
                            @if(!empty($category->articles))
                                @foreach($category->articles as  $catarticle)
                                    <div class="row padl_sub2 out_list_title">
										<p class="pdf_box">
			                            	<a href="/yearly/article/{{ $catarticle->id }}">
												<strong>{{ $catarticle->title }}</strong>
                                        	</a>
			                            	<a target="_blank" href="/yearly/pdf_article/{{ $catarticle->id }}" class="pdf"></a>
                                        </p>
	                                    <?php
	                                    $description = explode(' ', ltrim(html_entity_decode(strip_tags($catarticle->body))));
	                                    count($description) <40 ? $count = count($description): $count = 40;
	                                    $descrurtion_short = implode(' ', array_slice($description,0, $count));
	                                    ?>
										<p style="text-align: justify">
											<span>{{$descrurtion_short}}...</span>
										</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if(!empty($category->subcategories))
                            @foreach($category->subcategories as  $subcategory)
                                    <div class="row padl_sub1 out_list_title">

                                        <p class="pdf_box">
	                                        {{ $subcategory->title }}
	                                        <span>
	                                            <a target="_blank" href="/yearly/pdf_subcategory/{{ $subcategory->id }}" class="pdf"></a>
	                                        </span>
	                                    </p>

                                        @if(!empty($subcategory->articles))
                                            @foreach($subcategory->articles as  $article)
                                                <div class="row padl_sub2 out_list_title">
                                                    <p class="pdf_box">
							                            <a href="/yearly/article/{{ $article->id }}">
	                                               			{{ $article->title }}
	                                                	</a>
							                            <a target="_blank" href="/yearly/pdf_article/{{ $article->id }}" class="pdf"></a>
	                                                </p>
	                                                <?php
	                                                $description = explode(' ', ltrim(html_entity_decode(strip_tags($article->body))));
	                                                count($description) <40 ? $count = count($description): $count = 40;
	                                                $descrurtion_short = implode(' ', array_slice($description,0, $count));
	                                                ?>
													<p style="text-align: justify">
														<span>{{$descrurtion_short}}...</span>
													</p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
            @endif
        </div>
            <div class="row box_save_article mt30">
            	@if(Request::url() == URL::previous())
				    <a href="/analyst/yearly/" class="button butt_back">Все отчеты</a>
				@else
					<a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
				@endif
					@if( $role != 'user' && $role !='employee' )
				<a class="button butt_def" href="/analyst/yearly/add2/{{ $yearlyreport->id }}">Редактировать</a>
					@endif
            </div>
@endsection
