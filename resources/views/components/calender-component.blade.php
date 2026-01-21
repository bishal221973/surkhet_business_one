{{-- <div>
    @php
        print_r(currentYMD())
    @endphp
    {{ getDaysInMonth(currentYMD()['year'], currentYMD()['month']) }}

    {{ convertDayToNepali(startDayofMonth(currentYMD()['year'], currentYMD()['month'])) }}
</div> --}}
@php
    // Current BS date
    $bs = currentYMD();

    // Selected year & month (from dropdown)
    $year = request('year', $bs['year']);
    $month = request('month', $bs['month']);

    // Highlight today only if same month/year
    $today = $year == $bs['year'] && $month == $bs['month'] ? $bs['day'] : null;

    // Total days in BS month
    $totalDays = getDaysInMonth($year, $month);

    // startDayofMonth returns day name (Sunday–Saturday)
    $startDayName = startDayofMonth($year, $month);

    // Day name → index map
    $dayMap = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6,
    ];

    $startDay = $dayMap[$startDayName];

    // Nepali weekdays
    $weekDays = ['आइतवार', 'सोमवार', 'मंगलवार', 'बुधवार', 'बिहीवार', 'शुक्रवार', 'शनिवार'];

    $day = 1;

    $bsMonths = [
        1 => 'बैशाख',
        2 => 'जेठ',
        3 => 'असार',
        4 => 'साउन',
        5 => 'भदौ',
        6 => 'आश्विन',
        7 => 'कार्तिक',
        8 => 'मंसिर',
        9 => 'पुष',
        10 => 'माघ',
        11 => 'फाल्गुन',
        12 => 'चैत्र',
    ];

    $prevMonth = $month - 1;
    $prevYear = $year;
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }

    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
@endphp

{{-- Month / Year Selector --}}


{{-- Calendar --}}
<div class="d-flex">
    <div class="w-100">
        @include('components.calender.calender')
    </div>
    <div style="width: 350px"></div>
</div>
