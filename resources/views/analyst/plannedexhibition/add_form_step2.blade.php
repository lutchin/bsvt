@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<h3> Управление отчетами типа {{$reporttitle}} {{date("Y",$plannedexhibitionyear->start_date)}}</h3>
		</div>
		<div class="row justify-content-center">

			<a href="/analyst/plannedexhibition/add3/{{$plannedexhibitionyear->id}}"><button class="butt margin_b butt_def">Создать новую выставку</button></a>

			<div class="col-md-12 out_table analyst_report">
				<table style="border: 1px solid">
					<thead>
					<tr style="border: 1px solid">
						<td style="width: 3%;">
							№ n/n
						</td>
						<td style="width: 35%;">Название</td>
						<td style="width: 15%;">Статус</td>
						<td style="width: 10%;">Редактировать</td>
						<td style="width: 10%;">Удалить</td>
						<td style="width: 17%;">Утвердить</td>
						<td style="width: 10%;">Скачать материалы к выставке</td>
					</tr>
					</thead>
					@foreach($reports as $item)
						<tr>
							<td>
								{{ ++$loop->index }}
							</td>
							<td>
								<a style="font-family: 'SegoeUI'" href="/analyst/plannedexhibition/article/{{ $item['id']}}"><?php echo strip_tags
									($item->title, "<p><a><h1><h2><h3><h4><h5><h6>");?> ({{ date("d
									.m",$item['start'])
									}} -	{{ date
									("d.m
									 Y",
									$item['fin']) }}) </a>
							</td>
							<td>
								@if($item['published'] != 2)
									Не опубликован
								@else
									Опубликован
								@endif
							</td>
							<td>
								<a class="text_decor" href="/analyst/plannedexhibition/upd/{{ $item['id'] }}">Редактировать</a>
							</td>
							<td>
								<form onsubmit="deleteName(this,'{{$reporttitle}} ( {{ date("d.m.Y",$item['start'])  }} - {{ date("d.m.Y",$item['fin']) }} )');return false;" action="/analyst/plannedexhibition/{{ $item['id'] }}/delete_article" method="post">
									{{ method_field('delete') }}
									@csrf
									<button class="text_decor link">Удалить</button>
								</form>
							</td>
							<td>
								@if($item['published'] != 2)
									<form action="/analyst/plannedexhibition/article_publish/{{ $item['id'] }}" method="post">
										{{ method_field('put') }}
										@csrf
										<button class="text_decor red no-btn">Утвердить</button>
									</form>
									{{--<a class="text_decor red" href="/analyst/plannedexhibition/upd/{{ $item['id'] }}">Утвердить</a>--}}
								@else
									Опубликован
								@endif
							</td>
							<td style="text-align: center;">
                <div class="file_wrap">
                @if(isset($item->images))
                  @foreach($item->images as $image)
                    <a target="_blank" href="/images/{{$image->image}}" class="file_img exhibition"></a>                    
									@endforeach
								@endif
								<!--a class="text_decor" href="/analyst/plannedexhibition/article/{{ $item['id']}}">Просмотреть</a-->
            </div>
							</td>


						</tr>
					@endforeach
					<tbody>
					</tbody>
				</table>

			</div>
		</div>
	</div>
	<div class="pagination">{{$reports->links()}}</div>
	
	<div class="row box_save_article mt30">
		@if($plannedexhibitionyear['published'] != 2 &&  $plannedexhibitionyear['published'] != -1)

			<form action="/analyst/plannedexhibition/publish/{{ $plannedexhibitionyear['id'] }}" method="post">
				{{ method_field('put') }}
				@csrf
				<button class="butt butt_mt_2 butt_def">Утвердить все материалы и опубликовать</button>
			</form>
		@endif
		<a href="/analyst/plannedexhibition"><button class="butt butt_mt_2 butt_def">Все выставки</button></a>
        <a href="/analyst"><button class="butt butt_mt_2 butt_def">Вернуться на главную</button></a>
    
    </div>
    
@endsection