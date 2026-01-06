<div class="row">
    <div class="col-md-12">
        <div class="timeline">
            @foreach ($timelines as $index => $timeline)
                <div class="time-label"><span class="text-bg-danger">{{ getFormatedDate($index) }}</span></div>
                @foreach ($timeline as $item)
                    <div>
                        {{-- {{ $item->type }} --}}
                        @if ($item->type == 'organization')
                            <i class="timeline-icon fa fa-building text-bg-primary"></i>
                        @elseif($item->type == 'user')
                            <i class="timeline-icon fa fa-user text-bg-primary"></i>
                        @endif
                        <div class="timeline-item">
                            <span class="time"> <i class="bi bi-clock-fill"></i> {{ $item->time }} </span>
                            <h3 class="timeline-header">
                                {{ $item->title }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>
    </div>
</div>
