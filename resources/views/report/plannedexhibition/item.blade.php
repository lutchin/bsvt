<?php

function m_name ( $m ) {
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
 $role = Auth::user()->roles[0]->title;
?>
@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center posr">

			<h3>
				Перечень международных выставок вооружений и военной техники, планируемых к проведению в иностранных государствах на {{ date("Y",$plannedexhibitionyear->start_date) }} год
				
				@if(Auth::user() && Auth::user()->isemployee())
    				<span>
    	                <a target="_blank" href="/plannedexhibition/pdf_item/{{ $plannedexhibitionyear->id }}" class="pdf"></a>
    	            </span>
	            @endif
	            
			</h3>
            @if( $role != 'user' && $role !='employee' )
            <span class="pos_tr_article_out status st-{{10 + $plannedexhibitionyear->published}}">
            	@if($plannedexhibitionyear->published == 2)
                    <span class="status st_inherit">Статус:</span> Опубликован
                @elseif($plannedexhibitionyear->published == 1)
                    <span class="status st_inherit">Статус:</span> Все материалы утверждены
                @elseif($plannedexhibitionyear->published == 0)
                    <span class="status st_inherit">Статус:</span> Не опубликован
                @endif
            </span>
            @endif
		</div>
        <div class="row justify-content-center">
            <div class="col-md-12 out_table analyst_report">
                    <table style="border: 1px solid">
                        <thead>
                        <tr style="border: 1px solid">
                          <td style="width: 3%;">
                              № n/n
                          </td>
                          <td style="width: 30%;">Название выставки</td>
                          <td style="width: 10%;">Дата</td>
                          <td style="width: 20%;">Место</td>
                          <td style="width: 27%;">Тематика выставки</td>
                          <td style="width: 10%;">Скачать материалы к выставке</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($reports as $item)
                            <tr style="border: 1px solid">
                                <td>
                                    {{ ++$loop->index }}
                                </td>
                                <td style="color: black !important">
                                    <a href="/plannedexhibition/article/{{ $item['id']}}">
                                        <?php echo
                                            strip_tags ($item['title'], "<p><a><h1><h2><h3><h4><h5><h6><b>");
                                        ?>
                                    </a>

                                    {{--@if(Auth::user() && Auth::user()->isemployee())--}}
                                    {{--<a target="_blank"  href="/pla  nnedexhibition/pdf_article/{{ $item['id']}}" class="pdf"></a>--}}
                                    {{--@endif--}}

                                </td>
                                <td style="border: 1px solid;" class="center">
                                    {{ date("d",$item['start']) }} - {{ date("d",$item['fin']) }}  {{ m_name(date("m",$item['fin'])) }}
                                </td>
                                <td style="border: 1px solid;">
                                    <?php echo strip_tags ($item['place'], "<p><a><h1><h2><h3><h4><h5><h6><b>")?>
                                </td>
                                <td>
                                    <?php echo strip_tags ($item['theme'], "<p><a><h1><h2><h3><h4><h5><h6><b>")?>
                                </td>
                                <td style="border: 1px solid; text-align:center;">
                                  <div class="file_wrap">
                                    @foreach( $item['images'] as $image )
                                        <a target="_blank" href="/images/{{ $image->image }}" class="file_img exhibition"></a> 
                                    @endforeach
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        </div>

	</div>
	<div class="pagination">{{$reports->links()}}</div>

    @if( $role != 'user' && $role !='employee' )
            <div class="row box_save_article mt30">

                @if(Request::url() == URL::previous())
                    <a href="/analyst/plannedexhibition/" class="button butt_back">Все отчеты</a>
                @else
                    <a href="{{ URL::previous() }}" class="button butt_back">Назад</a>
                @endif

                <a class="button butt_def" href="/plannedexhibition/add2/{{ $plannedexhibitionyear->id }}">Редактировать</a>

            </div>
        @else

	<div class="row justify-content-center">
		<a href="/"><button class="butt butt_mt_2 butt_def">Вернуться на главную</button></a>
	</div>
        @endif
@endsection
