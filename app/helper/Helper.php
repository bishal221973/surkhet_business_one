<?php

use App\Models\Organization;
use App\Models\Timeline;
use Carbon\Carbon;
if (!function_exists('bs_to_ad')) {
    function bs_to_ad($npDate)
    {
        return \App\Helpers\DateConverter::BsToAd('-', $npDate);
    }
}

if (!function_exists('ad_to_bs')) {
    function ad_to_bs($enDate)
    {
        return \App\Helpers\DateConverter::AdToBsEn('-', $enDate);
    }
}

function getDaysInMonth($year, $month)
{
    return \App\Helpers\DateConverter::getDaysInMonth($year, $month);
}

function getDayCountInMonth($year, $month, $day)
{
    return \App\Helpers\DateConverter::getDayCountInMonth($year, $month, $day);
}

function getSaturdaysInMonth($year, $month)
{
    return \App\Helpers\DateConverter::getSaturdaysInMonth($year, $month);
}

function convertDayToNepali($day)
{
    $day = strtolower($day); // normalize input

    $days = [
        'sunday' => 'आईतवार',
        'monday' => 'सोमबार',
        'tuesday' => 'मंगलवार',
        'wednesday' => 'बुधबार',
        'thursday' => 'बिहीबार',
        'friday' => 'शुक्रबार',
        'saturday' => 'शनिबार',
    ];

    return $days[$day] ?? null; // return Nepali day or null if invalid
}

function currentYMD()
{
    $today = Carbon::now()->format('Y-m-d'); // e.g., "2025-12-16"

    // Convert to Nepali date
    $bsDate = ad_to_bs($today); // returns "2082-08-01"

    // Split into array
    [$year, $month, $day] = explode('/', $bsDate);

    // Current Nepali year and month as array
    return $currentBS = [
        'year' => (int) $year,
        'month' => (int) $month,
        'day' => (int) $day,
    ];
}

function createTimeline($title, $description, $type)
{
    Timeline::create([
        'title' => $title,
        'description' => $description,
        'type' => $type,
    ]);
}

function getFormatedDate($adDate)
{
    $dateFormat = App\Models\OrganizationSetting::where('key', 'date_format')->first();
    $dateType = App\Models\OrganizationSetting::where('key', 'date_type')->first();
    $adDate = Carbon::parse($adDate)->format("Y-m-d");

    if ($dateType->value == 'AD Date') {
        return Carbon::parse($adDate)->format($dateFormat->value);
    }
    $bsDate = ad_to_bs($adDate);
    return Carbon::parse($bsDate)->format($dateFormat->value);
}


function organization(){
    return Organization::where('id', auth()->user()->organization_id)->first();
}

function getAdDate($date){
        $dateType = App\models\OrganizationSetting::where('key', 'date_type')->first();

        if($dateType->value == 'AD Date'){
            return $date;
        }
        return bs_to_ad($date);
}
