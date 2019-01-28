<?php $role = Auth::user()->roles[0]->title;?>
<?php
	function MName($m) {
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
		        $m_name = 'декабряь';
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
    <div class="container posr">
        <div class="row justify-content-center">
            <h3> Отчеты типа "{{$reporttitle}}"</h3>
        </div>
        <div class="row justify-content-center">
			@if( $role != 'user' && $role !='employee' )

            <a href="/analyst/monthly/add1"><button class="butt margin_b butt_def">Создать новый отчет</button></a>
			@endif
            <div class="col-md-12 out_table analyst_report">
					<table style="border: 1px solid">
					<thead>
					<tr style="border: 1px solid">
						<td style="width: 3%;">
							№ n/n
						</td>
						<td style="width: 25%;">Название</td>
						@if( $role != 'user' && $role !='employee' )
							<td style="width: 15%;">Статус</td>
						@endif
						<td style="width: 17%;">Просмотр</td>
						@if( $role != 'user' && $role !='employee' )
							<td style="width: 15%;">Редактирование</td>
							<td style="width: 15%;">Удаление</td>
							<td style="width: 10%;">Публикация</td>
						@endif
					</tr>
					</thead>
					<tbody>
                @foreach($reports as $item)

                    <tr>
						<td style="border: 1px solid">
							{{ ++$loop->index }}
						</td>

                        <td class="table_name">
	                        <a href="/monthly/show/{{ $item['id']}}">
								Некоторые аспекты развития вооружений, военной и специальной техники за рубежом № {{ $item['number'] }} ({{ MName(date("m",$item['start_date']))  }} {{ date("Y",$item['start_date']) }}) г.
								</a>
							@if( $role != 'user' && $role !='employee' )
							<a class="link-edit" href="/analyst/monthly/updreport/{{ $item['id'] }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							@endif
	                    </td>
						@if( $role != 'user' && $role !='employee' )
							<td>
								@if($item['published'] == 2)
									Опубликован
								@elseif($item['published'] == -1)
									Нет материалов
								@else
									Не опубликован
								@endif
							</td>
						@endif
                        <td>
                            <a class="text_decor" href="/monthly/show/{{ $item['id']}}">Просмотреть</a>
                        </td>
						@if( $role != 'user' && $role !='employee' )
                        <td>
     
                            <a class="text_decor" href="/analyst/monthly/add2/{{ $item['id'] }}">Редактировать</a>
    
                        </td>
                        <td>
                        	
                        	<form onsubmit="deleteName(this,'{{$reporttitle}} ( {{ date("d",$item['start_date'])  }}.{{ $item['month'] }} - {{ date("d",$item['end_date']) }}.{{ $item['month']}}.{{$item['year'] }})');return false;" action="/analyst/monthly/{{ $item['id'] }}/deletereport" method="post">
                                {{ method_field('delete') }}
                                @csrf
                                <button class="text_decor link">Удалить</button>
                            </form>

                            
                        </td>
                        <td>
                        	
                        	@if($item['published'] == 1)
                            	
                            	<form action="/analyst/monthly/publish/{{ $item['id'] }}" method="post">
	                                {{ method_field('put') }}
	                                @csrf
	                                <button class="text_decor link">Опубликовать</button>
	                            </form>
	                            
	                        @elseif($item['published'] == 2) 
	                        
	                        	    Опубликован
	                        	    
                            @elseif($item['published'] == -1) 
                            
                            	Нет материалов
                            	
                            @elseif($item['published'] == 1) 
                                                        
                            	Ожидает утверждения
                            	
                            @else 
                                <a class="text_decor red" href="/analyst/monthly/add2/{{ $item['id'] }}">Утвердите материалы</a>                	
                            @endif 
                        </td>
						@endif
                    </tr>

                @endforeach
					</tbody>
			</table>
            </div>
        </div>
    </div>
    <div class="pagination">{{$reports->links()}}</div>
    <div class="row justify-content-center">
        <a href="/analyst"><button class="butt butt_mt_2 butt_def">Вернуться на главную</button></a>
    </div>
@endsection
