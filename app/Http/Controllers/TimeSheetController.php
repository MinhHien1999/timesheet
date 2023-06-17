<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\Day;
use App\Models\Time;

class TimeSheetController extends Controller
{
    public function CalcTimeSheet(Request $request){
        $request->validate([
            'day' => ['required','date'],
            'start_time' => ['required','date_format:H:i'],
            'finish_time' => ['required','date_format:H:i','after:start_time'],
        ]);

        $date_default = date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay = date("l",strtotime($request->day));
        $getStart = strtotime(date('H:i',strtotime($request->start_time)));
        $getFinish = strtotime(date('H:i',strtotime($request->finish_time)));
        $totalTimeSheet = round(($getFinish - $getStart) /60/60,2);

        if($this->CheckWeekend($getDay) == true){
            $this->save($request->day, $request->start_time, $request->finish_time, $this->CalcWeekend($getDay, $totalTimeSheet));
            return redirect()->back();
        }
        $this->save($request->day, $request->start_time, $request->finish_time, $this->HandleDayEvenOdd($getDay, $getStart, $getFinish, $totalTimeSheet));
        return redirect()->back();
    }
    private function CheckWeekend($day)
    {
        if($day == 'Saturday' || $day == 'Sunday')
        {
            return true;
        }
        return false;
    }
    private function CheckDayEvenOdd($day)
    {
        // Odd = FALSE, Even = TRUE
        $flag = false;
        if($day == 'Monday' || $day == 'Wednesday' || $day == 'Friday'){
            $flag = true;
        }
        return $flag;
    }
    private function HandleDayEvenOdd($getDay, $getStart, $getFinish, $totalTimeSheet){
        $getStartInside = 0;
        $getFinishInside = 0;
        if($this->CheckDayEvenOdd($getDay) == true){
            $getStartInside = strtotime(date('H:i',mktime(7,00)));
            $getFinishInside = strtotime(date('H:i',mktime(19,00)));
        }else{
            $getStartInside = strtotime(date('H:i',mktime(5,00)));
            $getFinishInside = strtotime(date('H:i',mktime(17,00)));
        }
        if($getStart >= $getStartInside && $getFinish <= $getFinishInside){
            return $this->CalcWeeklyInside($getDay,$totalTimeSheet);
        }
        // Start outside & Finish inside || Start inside & finish outside
        else{
            return $this->CalcWeeklyInOutSide($getDay,$getStart, $getFinish, $totalTimeSheet, $getStartInside, $getFinishInside);
        }
    }
    private function CalcWeekend($day, $totalTimeSheet)
    {
        return Day::WEEKEND[$day] * $totalTimeSheet;
    }
    private function CalcWeeklyInside($day, $totalTimeSheet)
    {
        return Day::DAY_INSIDE[$day] * $totalTimeSheet;
    }
    private function CalcWeeklyInOutSide($getDay, $getStart, $getFinish, $totalTimeSheet, $getStartInside, $getFinishInside)
    {
        $getStartOutSide = 0;
        $getFinishOutSide = 0;
        if($getStart < $getStartInside)
        $getStartOutSide = round(($getStartInside - $getStart) /60/60,2);
        if($getFinish > $getFinishInside)
        $getFinishOutSide = round(($getFinish - $getFinishInside) /60/60,2);
        return (($getStartOutSide + $getFinishOutSide) * Day::DAY_OUTSIDE[$getDay]) + 
        (($totalTimeSheet - $getStartOutSide - $getFinishOutSide) * Day::DAY_INSIDE[$getDay]);
    }
    private function save($day, $start, $finish, $amount){
        $timesheet = new Time();
        $timesheet->date = $day;
        $timesheet->start = $start;
        $timesheet->finish = $finish;
        $timesheet->amount = $amount;
        $timesheet->save();
        return true;
    }
}