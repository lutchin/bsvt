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
            {{ $variousreport->number }} {{--за период от {{date("d.m.Y",$variousreport->start_date)}} до {{date("d.m.Y",$variousreport->end_date)}}--}}
            <span>
                <a target="_blank" href="/various/pdf_item/{{ $variousreport->id }}" class="pdf"></a>
            </span>
        </h3>
        @if( $role != 'user' && $role !='employee' )
            <span class="pos_tr_article_out status st-{{10 + $variousreport->published}}">
        	@if($variousreport->published == 2)
              <span class="status st_inherit">Статус:</span> Опубликован
          @elseif($variousreport->published == 1)
              <span class="status st_inherit">Статус:</span> Все материалы утверждены
          @elseif($variousreport->published == 0)
              <span class="status st_inherit">Статус:</span> Не опубликован

          @endif
        </span>
        @endif
        
        @if(!empty($items))
            @foreach($items as  $report)
                @if(!empty($report->articles))
                    @foreach($report->articles as  $article)
                        <div class="row padl_sub2 out_list_title">

                            <a href="/various/article/{{ $article->id }}">
                                <p class="pdf_box">
                                            	<span>
                                            		{{ $article->title }}
                                            	</span>
                                    <span>
                									<a target="_blank" href="/various/pdf_article/{{ $article->id }}" class="pdf"></a>
                								</span>
                                  <?php
                                  $description = explode(' ', ltrim(html_entity_decode(strip_tags($article->body))));
                                  count($description) <40 ? $count = count($description): $count = 40;
                                  $descrurtion_short = implode(' ', array_slice($description,0, $count));
                                  ?>
                                  <p style="text-align: justify; margin-left: 10px">
                                    <span> {{$descrurtion_short}}...</span>
                                  </p>
                                </p>
                            </a>
                        </div>
                    @endforeach

                @endif
            @endforeach

        @endif
        </div>
            <div class="row box_save_article mt30">

                <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                @if( $role != 'user' && $role !='employee' )
                    <a class="button butt_def" href="/analyst/various/add2/{{ $variousreport->id }}">Редактировать</a>
                @endif
            </div>

            <!-- modalka cat -->
            <div class="popup popup_cat" style="display: none;">
                <div class="bg_popup bg_popup_cat"></div>
                <form action="/analyst/various/createcategory" method="POST" class="popup_form">
                    @csrf
                    <input type="text" hidden name="variousreport" value="{{ $variousreport->id }}">
                    <input type="text" hidden name="year" value="<?= $y?>">
                    <input type="text" hidden name="month" value="<?= $m?>">
                    <div class="close_pop close_popup_cat">x</div>

                    <h4 class="mb30">Добавить <span>раздел</span></h4>
                    <div class="popup_form_box mb30">
                        <input name="title" placeholder="Введите название раздела"/>
                    </div>
                    <a class="butt_save butt_add_region" href="#">
                        <button>Сохранить</button>
                    </a>
                </form>
            </div>

            <!-- modalka subcat -->
            <div class="popup popup_subcat" style="display: none;">
                <div class="bg_popup bg_popup_subcat"></div>
                <form action="/analyst/various/createsubcategory" method="POST" class="popup_form">
                    @csrf
                    <input type="text" hidden name="variousreport" value="{{ $variousreport->id }}">
                    <input type="text" hidden name="yearlycategory" value="">
                    <input type="text" hidden name="year" value="<?= $y?>">
                    <input type="text" hidden name="month" value="<?= $m?>">
                    <div class="close_pop close_popup_subcat">x</div>

                    <h4 class="mb30">Добавить <span>подраздел</span></h4>
                    <div class="popup_form_box mb30">
                        <input name="title" placeholder="Введите название подраздела"/>
                    </div>
                    <a class="butt_save butt_add_region" href="#">
                        <button>Сохранить</button>
                    </a>
                </form>
            </div>
@endsection
