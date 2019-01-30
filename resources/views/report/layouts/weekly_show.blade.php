@foreach($posts as  $post)
    @if(isset($post))

        <div class="row padl1 out_list_title">
            <p class="pdf_box">
                                    <span>
                                        <a href="/report/weekly/article/{{ $post->id }}">
                                            <strong>{{ $post->title }}</strong>
                                        </a>
                                    </span>
                                    <span>
                                        <a target="_blank" href="/pdf_article/{{ $post->id }}" class="pdf"></a>
                                    </span>
            <?php
            $description = explode(' ', ltrim(html_entity_decode(strip_tags($post->description))));
            count($description) <40 ? $count = count($description): $count = 40;
            $descrurtion_short = implode(' ', array_slice($description,0, $count));
            ?>
            <p style="text-align: justify">
                <span>{{$descrurtion_short}}...</span>
            </p>
            @if( $role != 'user' && $role !='employee' )
                @if($post->status == 0 && $report->status!=2)
                    <span class="status st-line st-0">| Не утверждено</span>
                @elseif($post->status == 1 && $report->status!=2)
                    <span class="status st-line st-1">| Ожидает утверждения</span>
                @elseif($post->status == 2 && $report->status!=2)
                    <span class="status st-line st-2">| Утверждено</span>
                @endif
            @endif

        </div>
    @endif
@endforeach