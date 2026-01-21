<div class="card shadow-sm">
    <div style="background-color: var(--primary-color)"
        class="card-header d-flex justify-content-between align-items-center">
        <div class=" text-start fw-bold w-100 text-white">
            {{ $year }} {{ $bsMonths[$month] }} / {{ now()->format('M Y') }}
        </div>
        <form method="GET" class="d-flex justify-content-end w-100 gap-1">
            <a href="{{ url()->current() }}?year={{ $prevYear }}&month={{ $prevMonth }}"
                class="btn btn-outline-primary " style="background-color: var(--primary)">
                <i class="fa fa-angle-left text-white"></i>
            </a>
            <div>
                <select name="year" class="form-control btn-outline-primary text-white" onchange="this.form.submit()"
                    style="background-color: var(--primary);color:white !important">
                    @for ($y = $bs['year'] - 5; $y <= $bs['year'] + 5; $y++)
                        <option value="{{ $y }}" @selected($y == $year)>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <select name="month" class="form-control btn-outline-primary" onchange="this.form.submit()"
                    style="background-color: var(--primary);color:white !important">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" @selected($m == $month)>
                            {{ $bsMonths[$m] }}
                        </option>
                    @endfor
                </select>
            </div>
            <a href="{{ url()->current() }}?year={{ $nextYear }}&month={{ $nextMonth }}"
                class="btn btn-outline-primary" style="background-color: var(--primary)">
                <i class="fa fa-angle-right text-white"></i>
            </a>

        </form>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered text-center mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    @foreach ($weekDays as $i => $weekDay)
                        <th class="{{ $i === 6 ? 'text-danger' : '' }}">
                            {{ $weekDay }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @for ($row = 0; $row < 6; $row++)
                    <tr>
                        @for ($col = 0; $col < 7; $col++)
                            @php
                                $cell = $row * 7 + $col;
                            @endphp

                            <td style="height:60px;width:12%" class="{{ $col === 6 ? 'text-danger' : '' }}">

                                @if ($cell >= $startDay && $day <= $totalDays)
                                    <span class="{{ $day == $today ? 'badge bg-primary' : '' }}">
                                        {{ $day }}
                                    </span>
                                    <div style="height: 40px" class="p-0">
                                        {{-- {{ $year }} --}}
                                        @include('components.calender.event')
                                    </div>
                                    @php $day++; @endphp
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
