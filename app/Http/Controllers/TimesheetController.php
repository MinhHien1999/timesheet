<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    //
    public function viewTimesheet(){
        return view('index')->with('data', Timesheet::all());
    }

    public function createTimesheet(request $request){
        $request->validate([
            'Day' => 'required|date|before:tomorrow',
            'Start' => 'required|date_format:H:i',
            'Finish' => 'required|date_format:H:i|after:Start'
        ],[
            'Day.required' => 'required',
            'Day.before' => "Can't be in the future",
            'Start.required' => 'required',
            'Finish.required' => 'required',
            'Finish.after' => "Can't be before start time"
        ]);

        $date_default = date_default_timezone_set('Asia/Ho_Chi_Minh');
        $getDay = date("l",strtotime($request->Day));

        $getStart = strtotime(date('H:i',strtotime($request->Start)));
        $getFinish = strtotime(date('H:i',strtotime($request->Finish)));

        $totalBreak = round(($getFinish - $getStart) /60/60,2); //format minutes, hours ex: 3.06

        $amount = 0;

        if($getDay =="Monday" || $getDay =="Wednesday" || $getDay =="Friday")
        {
            $getStartInside = strtotime(date('H:i',mktime(7,00)));
            $getFinishInside = strtotime(date('H:i',mktime(19,00)));
            // $totalInsideBreak = 0;
            if( ($getStart < $getStartInside && $getFinish < $getStartInside) || ($getStart >= $getFinishInside && $getFinish > $getFinishInside) )
            {
                $amount = $totalBreak * 34;
            }
            elseif( ($getStart < $getStartInside && $getFinish <= $getFinishInside) ){
                $totalOutsideBreak = ($getStartInside - $getStart)/60;
                $totalInsideBreak =  (($getFinish - $getStart) /60) - $totalOutsideBreak;
                $amount = (round($totalInsideBreak/60,2) * 22) + (round($totalOutsideBreak/60,2) * 34);
            }elseif( ($getStart >= $getStartInside && $getFinish > $getFinishInside) ){
                $totalOutsideBreak = ($getFinish - $getFinishInside)/60;
                $totalInsideBreak =  (($getFinishInside - $getStart)/60);
                $amount =  (round($totalInsideBreak/60,2) * 22) + (round($totalOutsideBreak/60,2) * 34);
            }elseif ( ($getStart >= $getStartInside && $getFinish <= $getFinishInside) ){
                $amount = (round(($getFinish - $getStart) /60/60,2) * 22);
            }else{
                $totalInsideBreak = round(($getFinishInside - $getStartInside) /60/60,2);
                $totalOutsideBreak = $totalBreak - $totalInsideBreak;
                $amount = ($totalInsideBreak * 22) + ($totalOutsideBreak * 34);
            }               
        }
        elseif($getDay =="Tuesday" || $getDay =="Thursday"){
            $getStartInside = strtotime(date('H:i',mktime(5,00)));
            $getFinishInside = strtotime(date('H:i',mktime(17,00)));
            // $totalInsideBreak = 0;
            if(($getStart < $getStartInside && $getFinish < $getStartInside) || ( $getStart >= $getFinishInside && $getFinish > $getFinishInside))
            {
                $amount = $totalBreak * 35;
            }
            elseif(($getStart < $getStartInside && $getFinish <= $getFinishInside)){
                $totalOutsideBreak = ($getStartInside - $getStart)/60;
                $totalInsideBreak =  (($getFinish - $getStart) /60) - $totalOutsideBreak;
                $amount = (round($totalInsideBreak/60,2) * 25) + (round($totalOutsideBreak/60,2) * 35);
            }elseif(($getStart >= $getStartInside && $getFinish > $getFinishInside)){
                $totalOutsideBreak = ($getFinish - $getFinishInside)/60;
                $totalInsideBreak =  (($getFinishInside - $getStart) /60);
                $amount = (round($totalInsideBreak/60,2) * 25) + (round($totalOutsideBreak/60,2) * 35);
                // return $amount;
            }elseif(($getStart >= $getStartInside && $getFinish <= $getFinishInside)){
                $amount = (round(($getFinish - $getStart) /60/60,2) * 25);
            }else{
                $totalInsideBreak = round(($getFinishInside - $getStartInside) /60/60,2);
                $totalOutsideBreak = $totalBreak - $totalInsideBreak;
                $amount = ($totalInsideBreak * 25) + ($totalOutsideBreak * 35);
            }
        }else{
            $amount = $totalBreak * 47;
        }

        $data = new Timesheet();
        $data->date = $request->Day;
        $data->start_time = $request->Start;
        $data->finish_time = $request->Finish;
        $data->amount = $amount;
        $data->save();
        return redirect()->route('view');

    }
}
