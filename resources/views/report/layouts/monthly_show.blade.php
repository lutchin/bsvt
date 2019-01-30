@foreach($posts as  $key =>$value)
    @if($key !== 'false')
        <?php $n2++; ?>
        <div class="row">
            <p class="title padl_sub1 title_sub_cat">
                {{ $n1 }}.{{ $n2 }}. {{ $key }}
                <span>
                                                <a target="_blank" href="/pdf_subcategory/{{ $report->id }}/{{ \App\Category::where('title',$cat)->first()->id }}/{{ \App\Subcategory::where('title',$key)->first()->id }}" class="pdf"></a>
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
                                                <a href="/report/{{ $report->types->slug }}/article/{{ $v->id }}">

                <p>  {{ $n1 }}.{{ $n2 }}.{{ $n3 }}. {{ $v->title }}</p>
                </a>
                </span>
                                            <span>
                                                <a target="_blank" href="/pdf_article/{{ $v->id }}" class="pdf"></a>
                                            </span>
                <?php
                $description = explode(' ', ltrim(html_entity_decode(strip_tags($v->description))));
                count($description) <40 ? $count = count($description): $count = 40;
                $descrurtion_short = implode(' ', array_slice($description,0, $count));
                ?>
                <p style="text-align: justify">
                    <span>{{$descrurtion_short}}...</span>
                </p>
                @if( $role != 'user' && $role !='employee' )
                    @if($v->status == 0 && $report->published!=2)
                        <p class="status st-line st-0">| Не утверждено</p>
                    @elseif($v->status == 1 && $report->status !=2)
                        <p class="status st-line st-1">| Ожидает утверждения</p>
                    @elseif($v->status == 2 && $report->status !=2)
                        <p class="status st-line st-2">| Утверждено</p>
                    @endif
                @endif
            </div>
        @endif
    @endforeach

@endforeach