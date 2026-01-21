@php
    $date = $year . '-' . $month . '-' . $day;
    $adDate = bs_to_ad($date);
@endphp

@php
    $projects = App\Models\Project::whereDate('start_date', $adDate)
        ->where('organization_id', organization()->id)
        ->get();
@endphp

@if (!$projects->isEmpty())
    @foreach ($projects as $project)
        <div class="badge px-1 bg-primary " style="font-size: 10px">  {{ Str::limit($project->project_name, 13) }}</div>
    @break
@endforeach
@else
{{-- <div class="badge bg-primary w-100"></div> --}}
@endif

<div style="font-size: 12px">
@if ($projects->count() > 1)
    {{ $projects->count() - 1 }} more
@endif
</div>
