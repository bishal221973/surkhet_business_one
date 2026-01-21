@php
    $date = $year . '-' . $month . '-' . $day;
    $adDate=bs_to_ad($date)
@endphp

{{ bs_to_ad($date) }}

@php
    $projects = App\Models\Project::whereDate('start_date', $adDate)->where('organization_id', organization()->id)->get();
@endphp

@if (!$projects->isEmpty())
    <ul>
        @foreach ($projects as $project)
           <div class="badge">{{ $project }}</div>
        @endforeach
    </ul>
@else
@endif
