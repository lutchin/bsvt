<?php $role = Auth::user()->roles[0]->title;?>
@extends('layouts.app')

@section('content')
<div class="container">
	<h3 class="title">Перечень международных выставок вооружений и военной техники, планируемых к проведению в иностранных государствах</h3>
	<div class="row justify-content-center">
		@if( $role != 'user' && $role !='employee' )
		<a href="/analyst/plannedexhibition/add1">
			<button class="butt margin_b butt_def">
				Создать новый отчет
			</button>
		</a>
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
						<a href="/plannedexhibition/show/{{ $item['id']}}">Выставки за  {{ date("Y",$item['start_date']) }} год</a>
						<a target="_blank" href="/plannedexhibition/pdf_item/{{ $item['id'] }}" class="pdf exhibition"></a>
						@if( $role != 'user' && $role !='employee' )
						<a class="link-edit" href="/analyst/plannedexhibition/updreport/{{ $item['id'] }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
						<a class="text_decor" href="/plannedexhibition/show/{{ $item['id']}}">Просмотреть</a>
					</td>
						@if( $role != 'user' && $role !='employee' )
					<td>
						<a class="text_decor" href="/plannedexhibition/add2/{{ $item['id'] }}">Редактировать</a>
					</td>
					<td>
						<form onsubmit="deleteName(this,'{{$reporttitle}} ( {{ date("d.m.Y",$item['start_date'])  }} - {{ date("d.m.Y",$item['end_date']) }} )');return false;" action="/analyst/plannedexhibition/{{ $item['id'] }}/delete_year" method="post">
							{{ method_field('delete') }}
							@csrf
							<button class="text_decor link">Удалить</button>
						</form>
					</td>
					<td>
						@if($item['published'] == 1)

							<form action="/analyst/plannedexhibition/publish/{{ $item['id'] }}" method="post">
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
							<form action="/analyst/plannedexhibition/publish/{{ $item['id'] }}" method="post">
								{{ method_field('put') }}
								@csrf
								<button class="text_decor red no-btn">Утвердить</button>
							</form>
							{{--<a class="text_decor red" href="/plannedexhibition/publish/{{ $item['id'] }}">Утвердить</a>--}}
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
	<a href="/">
		<button class="butt butt_mt_2 butt_def">
			Вернуться на главную
		</button>
	</a>
</div>
@endsection