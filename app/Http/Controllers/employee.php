<?php

namespace App\Http\Controllers;

use App\Models\allowBarcode;
use App\Models\employee as employeeModel;
use App\Models\feiertage;
use App\Models\permission;
use App\Models\tagesabschluss;
use App\Models\user;
use App\Models\zeiterfassung;
use App\Models\überwachung;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\IsEmpty;
use setasign\Fpdi\Fpdi;

class employee extends Controller
{
    public function loginEmployee(Request $req)
    {
        $username = $req->input('username');
        $password = $req->input('password');

        $account = 'awd';
        
        if ($account != null) {
            if (Auth::attempt(['username' => $username, 'password' => $password], true)) {
                // The user is being remembered...

                return redirect('/crm/auftragsübersicht-aktiv');
            } else {
                return view('forEmployees/administration/login')->with('account_notfound', 'Der Nutzer konnte nicht gefunden werden');

            }
        } else {
            return view('forEmployees/administration/login')->with('account_notfound', 'Der Nutzer konnte nicht gefunden werden');
        }
    }

    public function hasPermission($userid, $permission)
    {
        $user = permission::where('userid', $userid)->where('permission', $permission)->first();

        if ($user == null || $user == ' ') {
            return false;
        } else {
            return true;
        }
    }

    public function logoutEmployee(Request $req)
    {

            $req->session()->flush();
            Auth::logout(); 

            return redirect()->back();
        
    }

    public function zeiterfassungView(Request $req, $id)
    {
        $employee = employeeModel::where('user', $id)->first();

        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));

        if ($employee != null) {
            $time = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'start')->first();
        } else {
            $time = null;
        }

        $pause = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'pause')->first();

        $oldpause = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'old-pause')->get();

        $restart = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'weiter')->get();

        $historys = zeiterfassung::where('employee', $employee->id)->get();
        $feierabend = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'feierabend')->first();
        $seconddate = date('Y-m-d H:i:s');
        $parts = explode('-', $seconddate);
        $parts = explode(' ', $parts[2]);

        $firstdate = date('Y-m-d H:i:s', strtotime('-'.$parts[0].' days'));

        $worktimes = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->get();

        if ($pause == null) {
            if ($oldpause->isEmpty()) {
                return view('forEmployees/zeiterfassung/main')->with('times', $time)->with('history', $historys->sortByDesc('created_at'))->with('feierabend', $feierabend)->with('workdates', $worktimes);
            } else {
                return view('forEmployees/zeiterfassung/main')->with('times', $time)->with('oldpause', $oldpause)->with('restart', $restart)->with('history', $historys->sortByDesc('created_at'))->with('feierabend', $feierabend)->with('workdates', $worktimes);
            }
        } else {
            if ($oldpause->isEmpty()) {
                return view('forEmployees/zeiterfassung/main')->with('times', $time)->with('pause', $pause)->with('history', $historys->sortByDesc('created_at'))->with('feierabend', $feierabend)->with('workdates', $worktimes);
            } else {
                return view('forEmployees/zeiterfassung/main')->with('times', $time)->with('pause', $pause)->with('oldpause', $oldpause)->with('restart', $restart)->with('history', $historys->sortByDesc('created_at'))->with('feierabend', $feierabend)->with('workdates', $worktimes);
            }
        }
    }

    public function zeiterfassungStart(Request $req)
    {
        $employee = employeeModel::where('user', $req->input('employee'))->first();

        $time = new zeiterfassung();
        $time->employee = $employee->id;
        $time->type = 'start';
        $time->hours = $req->input('hours');
        $time->minutes = $req->input('minutes');
        $time->seconds = $req->input('seconds');
        $time->id = random_int(1, 10000);
        $time->save();
    }

    public function zeiterfassungProfilBearbeiten(Request $req) {
        $id     = $req->input("employee");
        $days   = $req->input("days");
        $hours  = $req->input("hours");
        $vacation = $req->input("vacation");
        $solldays = $req->input("solldays");

        $user = user::where("id", $id)->first();
        $user->workdays = $days;
        $user->soll = $solldays;
        $user->workhours =$hours;
        $user->allowed_vacations = $vacation;
        $user->update();

        return redirect()->back();
    }

    public function zeiterfassungPause(Request $req)
    {
        $employee = employeeModel::where('user', $req->input('employee'))->first();

        $time = new zeiterfassung();
        $time->employee = $employee->id;
        $time->type = 'pause';
        $time->id = random_int(1, 10000);
        $time->save();
    }

    public function zeiterfassungWeiter(Request $req)
    {
        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));
        $employee = employeeModel::where('user', $req->input('employee'))->first();

        $pause = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'pause')->first();

        try {
            DB::table('zeiterfassung')
            ->where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'pause')
            ->update(['type' => 'old-pause']);

            $time = new zeiterfassung();
            $time->employee = $employee->id;
            $time->type = 'weiter';
            $time->id = $pause->id;
            $time->save();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function zeiterfassungFeierabend(Request $req)
    {
        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));
        try {
            $employee = employeeModel::where('user', $req->input('employee'))->first();
            $startime = zeiterfassung::whereBetween('created_at', [$firstdate, $seconddate])->where('employee', $employee->id)->where('type', 'start')->first();
        } catch (\Throwable $th) {
            //throw $th;
        }
        try {
            $time = new zeiterfassung();
            $time->employee = $employee->id;
            $time->type = 'feierabend';
            $time->id = $startime->id;
            $time->save();
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function zeiterfassungÜbersicht(Request $req, $employee)
    {
        $employees = user::all();
        $employee = user::where("id", $employee)->first();
        $date = new DateTime();
        try {
            $firstdate = new DateTime($date->format("Y-m") . "-01");
            $seconddate = new DateTime($firstdate->format("Y-m") . "-31");
        } catch(Exception $e) {
            try {
                $firstdate = new DateTime($date->format("Y-m") . "-01");
                $seconddate = new DateTime($firstdate->format("Y-m") . "-30");
            } catch(Exception $e) {
                try {
                    $firstdate = new DateTime($date->format("Y-m") . "-01");
                    $seconddate = new DateTime($firstdate->format("Y-m") . "-29");
                } catch(Exception $e) {
                    try {
                        $firstdate = new DateTime($date->format("Y-m") . "-01");
                        $seconddate = new DateTime($firstdate->format("Y-m") . "-28");
                    } catch(Exception $e) {
                        
                    }
                }
            }
        }
        
        if(!isset($year)) {
            $date = new DateTime();
            $year = $date->format("Y");
            $month = $date->format("m");
        }

        $employees = user::all();
        $onlines = array();
        foreach($employees as $e) {
            $time = zeiterfassung::where("employee", $e->id)->latest()->first();
            if($time != null) {
                if($time->type == "start") {
                    array_push($onlines, $e);
                }
            }
        }

        $feiertage = feiertage::all();

        $times = zeiterfassung::where("employee", $employee->id)->whereBetween("created_at", [$firstdate, $seconddate])->get();
        $allTimes = zeiterfassung::whereBetween("created_at", [$firstdate->format($year . "-01-01 00:00:00"), $firstdate->format($year. "-12-31 23:59:59")])->where("employee", $employee)->get();

        return view('forEmployees/zeiterfassung/main')->with("feiertage", $feiertage)->with("onlines", $onlines)->with("allTimes", $allTimes)->with("employees", $employees)->with("selectedEmployee", $employee)->with("times", $times);
    }

    public function zeiterfassungDatum(Request $req, $employee, $year, $month) {

        $employees = user::all();
        $employee = user::where("id", $employee)->first();
        try {
            $seconddate = new DateTime($year."-".$month."-31");
            
            $firstdate = new DateTime($year."-".$year."-01");
        } catch(Exception $e) {
            $seconddate = new DateTime($month."-".$year."-30");
            $firstdate = new DateTime($month."-".$year."-01");
            $step = $month;
            $month = $year;
            $year = $step;
        }

        $employees = user::all();
        $onlines = array();
        foreach($employees as $e) {
            $time = zeiterfassung::where("employee", $e->id)->latest()->first();
            if($time != null) {
                if($time->type == "start") {
                    array_push($onlines, $e);
                }
            }
        }

        $feiertage = feiertage::all();

        $allTimes = zeiterfassung::whereBetween("created_at", [$firstdate->format($year . "-".$month."-01 00:00:00"), $firstdate->format($year. "-".$month."-31 23:00:00")])->where("employee", $employee->id)->get();
        $times = zeiterfassung::where("employee", $employee->id)->whereBetween("created_at", [$firstdate, $seconddate])->get();
        return view('forEmployees/zeiterfassung/main')->with("feiertage", $feiertage)->with("onlines", $onlines)->with("allTimes", $allTimes)->with("year", $year)->with("month", $month)->with("employees", $employees)->with("selectedEmployee", $employee)->with("times", $times);
    

    }

    public function zeiterfassungNeueZeit(Request $req) {
        $date       = $req->input("date");
        $employee   = $req->input("employee");
        $info       = $req->input("info");

        $date       = new DateTime($date);   

        $currentDate = new DateTime();

        if($date < $currentDate) {
            $seconddate = new DateTime($date->format("Y-m-d 23:59"));
        

            $times = zeiterfassung::where("employee", $employee)->get();
            foreach ($times as $time) {
                if($time->type == "start") {
                    $checkTime = zeiterfassung::where("employee", $employee)->where("id", $time->id)->where("type", "feierabend")->first();
                    if($checkTime == null) {
                        $checkTime = zeiterfassung::whereBetween("created_at", [$date->format("Y-m-d 00:00:00"), $seconddate])->where("type", "start")->get();
                        if($checkTime != null) {
                            foreach($checkTime as $t) {
                                if($times->where("id", $t->id)->where("type", "feierabend")->first() == null)  {
                                    

                                    return redirect()->back()->withErrors(["Für diesen Tag existiert bereits eine noch nicht gestoppte Zeit"]);
                                }
                            }
                        }
                    }
                }
            }

            $times       = zeiterfassung::whereBetween("created_at", [$date, $seconddate])->where("employee" ,$employee)->where("type", "start")->get();
            $smallestTime = new DateTime();
            foreach ($times as $time) {
                if ($time->created_at < $smallestTime) {
                    $smallestTime = $time->created_at;
                }
            }

            $latestTime = zeiterfassung::whereBetween("created_at", [$date, new DateTime($smallestTime->format("Y-m-". $date->format("d") ." H:" . $smallestTime->format("i") - 1))])->where("employee", $employee)->first();
            
            if($latestTime == null) {
                $reasonStartDate = new DateTime($date->format("Y-m-d 00:00:00"));
                $reasonEndDate = new DateTime($date->format("Y-m-d 23:59:00"));
                $reasonTime = zeiterfassung::whereBetween("created_at", [$reasonStartDate, $reasonEndDate])->where("employee", $employee)->first();
                $time = new zeiterfassung();

                $time->employee = $employee;
                $time->type = "start";

                if($reasonTime != null) {
                    $time->reason = $reasonTime->reason;
                } else {
                    $time->reason = "Arbeit";
                }
                $time->info = $info;
                $time->created_at = $date;
                $time->id = uniqid();
                $time->save();

                $currentStartDate = new DateTime($smallestTime->format("Y-m-d 00:00:00"));

                if($date < $currentStartDate) {
                    $überwachung = new überwachung();
                    $überwachung->employee = auth()->user()->id;
                    $überwachung->type = "Zeiterfassung";
                    $überwachung->text = "Der Nutzer hat die Zeit in der vergangenheit eingetragen";
                    $überwachung->save();
                }
            } else{
                return redirect()->back()->withErrors(["Die Zeit würde sich mit einer bereits gebuchten Zeit überlappen"]);
            }
        } else {
            return redirect()->back()->withErrors(["Zeiten dürfen nicht in die Zukunft gebucht werden"]);
        }

        return redirect()->back();
    }

    public function zeiterfassungStoppen(Request $req,) {

        $id     = $req->input("id");
        $date   = $req->input("date");
        $employee = $req->input("employee");

        $date       = new DateTime($date); 
        $currentDate = new DateTime();
        $startTime = zeiterfassung::where("type", "start")->where("id", $id)->where("employee", $employee)->first();
        $checkTime = new DateTime($startTime->created_at);
        if($date > $checkTime) {
            if($date < $currentDate) {
                $latestTime = zeiterfassung::whereBetween("created_at", [new DateTime($startTime->created_at), $date->format("Y-m-" . $startTime->created_at->format("d"). " H:i")])->where('id', '!=', $id)->where("employee", $employee)->first();
                if($latestTime == null) {
                    $time = new zeiterfassung();
                    $time->employee = $startTime->employee;
                    $time->type = "feierabend";
                    $time->reason = $startTime->reason;
                    $time->info = "";
                    $time->id = $startTime->id;
                    $time->created_at = $date;
                    $time->save();
                } else {
                    if($date->format("H:i") == $latestTime->created_at->format("H:i")) {
                        $time = new zeiterfassung();
                        $time->employee = $startTime->employee;
                        $time->type = "feierabend";
                        $time->reason = $startTime->reason;
                        $time->info = "";
                        $time->id = $startTime->id;
                        $time->created_at = $date;
                        $time->save();
                    } else {
                        return redirect()->back()->withErrors(["Die Zeit würde sich mit einer bereits gebuchten Zeit überlappen"]);
                    }
                }
            } else {
                return redirect()->back()->withErrors(["Zeiten würden nicht in die Zukunft gebucht werden"]);
            }
        } else {
            return redirect()->back()->withErrors(["Die Zeit darf nicht kleiner als die Startzeit sein"]);

        }
        
        return redirect()->back();
    }

    public function zeiterfassungBearbeiten(Request $req) {

        $start      = $req->input("start");
        $end        = $req->input("end");
        $employee   = $req->input("employee");
        $info       = $req->input("info");
        $reason     = $req->input("reason");
        $end        = new DateTime($start);
        $times = zeiterfassung::whereBetween("created_at", [new DateTime($end->format("Y-m-d 00:00:00")), new DateTime($end->format("Y-m-d 23:59:00"))])->where("employee", $employee)->get();
        foreach ($times as $time) {
            $time->info = $info;
            if($time->type == "start") {
                $time->reason = $reason;
                $time->save();
            } else if($time->type == "feierabend") {
                $time->reason = $reason;
                $time->save();
            }
        }

        return redirect()->back();
    }

    public function zeiterfassungDrucken(Request $req, $employee, $month, $year) {

        $seconddate = new DateTime($year . "-". $month. "-01");
        try {
            $firstdate  = new DateTime($year . "-". $month. "-31");
        } catch(Exception $e) {
            try {
                $firstdate  = new DateTime($year . "-". $month. "-30");
            } catch(Exception $e) {
                try {
                    $firstdate  = new DateTime($year . "-". $month. "-29");
                } catch(Exception $e) {

                }
            }
        }
        $times = zeiterfassung::whereBetween("created_at", [$seconddate, $firstdate])->where("employee", $employee)->get();
        
        $pdf = new Fpdi(); 
        
        // set the source file
        $pdf->setSourceFile(public_path("/"). "pdf/zeiterfassung_PDF.pdf");
        $pdf->AddPage();
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId); 
        $pdf->SetFont("Arial", "", 12);
        $pdf->SetTextColor(0,0,0);

        $multiplier = 41;

        $days = array();
        $dayCounter = 1;
        while ($dayCounter <= 31) {
            array_push($days, ["0" => $multiplier]);
            $multiplier += 5;
            $dayCounter++;
        }
        
        $usedDays = array();
        $usedTimes = array();
        $day = null;
        $count = 0;
        $pdf->Text(27, 207.5, "weitere Zeiten");
        foreach($times as $time) {
            try {
                $test = $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at;
            } catch (Exception $e) {
                return redirect()->back()->withErrors(["Es müssen alle Zeiten des Monats abgeschlossen sein!"]);
            }

           

            if($time->type == "start") {
                $day = $time->created_at->format("d.m.Y");
                    $date = $time->created_at->format("d");
                    if($date <= 10) {
                        if(!in_array($time->created_at->format("d"), $usedDays)) {
                            $pdf->Text(44, $days[substr($date, -1)][0], $time->created_at->format("H:i") . " - " . 
                                    $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));
                        } else {
                            $pdf->Text(70, $days[substr($date, -1)][0], $time->created_at->format("H:i") . " - " . 
                                    $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));
                        }
                        } else {
                        if(!in_array($time->created_at->format("d"), $usedDays)) {
                            if($day == $time->created_at->format("d.m.Y")) {
                                if($count < 2) {
                                    $pdf->Text(44, $days[$date][0] , $time->created_at->format("H:i") . " - " . 
                                        $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));
                                    array_push($usedDays, $time->created_at->format("d"));
                                    $count++;
                            } else {
                                $pdf->SetFont("Arial", "B", 15);
                                
                                $pdf->Text(112, $days[$date][0], "*");

                                $pdf->SetFont("Arial", "", 12);

                                $count = 0;

                                $pdf->Text(27, $days[$date][0] + 100, $time->created_at->format("d.m.Y, H:i") . " - " . 
                                $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));
                            }
                            }
                            
                        } else {
                            if($day == $time->created_at->format("d.m.Y")) {
                               if($count < 2) {
                                $pdf->Text(70, $days[$date][0], $time->created_at->format(", H:i") . " - " . 
                                $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));
                                $count++;
                               } else {
                                $pdf->SetFont("Arial", "B", 15);
                                
                                $pdf->Text(112, $days[$date][0], "*");

                                $pdf->SetFont("Arial", "", 12);

                                $count = 0;

                                $pdf->Text(27, $days[$date][0] + 112, $time->created_at->format("d.m.Y, H:i") . " - " . 
                                $times->where("id", $time->id)->where("type", "feierabend")->first()->created_at->format("H:i"));

                               }
                            } else {
                            }
                        }
                    }
            if(!in_array($time->created_at->format("d"), $usedTimes)) {
                $start = new DateTime($time->created_at->format("Y-m-d 00:00:00"));
                $end = new DateTime($time->created_at->format("Y-m-d 23:59:59"));
                $allTimes = zeiterfassung::whereBetween("created_at", [$start, $end])->where("employee", $employee)->get();
                
                $hours = 0;
                $minutes = 0;
                foreach($allTimes as $atime) {
                    $startdate = new DateTime($atime->created_at);
                    $diff_date = $startdate->diff(new DateTime($times->where("type", "feierabend")->where("id", $atime->id)->first()->created_at));
                    $hours += $diff_date->h;
                    $minutes += $diff_date->i;
                    if($minutes >= 60) {
                     $hours++;
                     $minutes -= 60;
                    }
                }
                if($hours <= 9) {
                    $hours = "0".$hours;
                }
                if($minutes <= 9) {
                    $minutes = "0".$minutes;
                }
                if($date <= 9) {
                    $pdf->Text(116, $days[substr($date, -1)][0], $hours . ":". $minutes);
                    $pdf->Text(129, $days[substr($date, -1)][0], $time->reason);
                    $pdf->Text(145, $days[substr($date, -1)][0], $time->info);

                    $sDate = new DateTime($time->created_at->format("Y-m-d 23:59:59"));
                    $timesCounter = zeiterfassung::whereBetween("created_at", [$time->created_at, $sDate])->where("employee", $employee)->get();
        
                    if($timesCounter != null) {
                        if($timesCounter->count() == 2) {
                            $pdf->Text(145, $days[substr($date, -1)][0], "Keine Pause gemacht");
                        }
                    }

                } else {
                    $pdf->Text(116, $days[$date][0], $hours . ":". $minutes);
                    $pdf->Text(129, $days[$date][0], $time->reason);
                    $pdf->Text(145, $days[$date][0], $time->info);

                    $sDate = new DateTime($time->created_at->format("Y-m-d 23:59:59"));
                    $timesCounter = zeiterfassung::whereBetween("created_at", [$time->created_at, $sDate])->where("employee", $employee)->get();
        
                    if($timesCounter != null) {
                        if($timesCounter->count() > 1) {
                            $pdf->Text(112, $days[$date][0], "*");
                        }
                    }

                }

               
                }

                array_push($usedTimes, $time->created_at->format("d"));

            }
            
        }
           
        

        dd($pdf->Output());

    }

    public function zeiterfassungEintragLöschen(Request $req, $id) {

        $times = zeiterfassung::where("id", $id)->get();
        foreach($times as $time) {
            $time->delete();
        }

        return redirect()->back();
    }

    public function zeiterfassungRestart(Request $req)
    {
        $employee = employeeModel::where('user', $req->input('employee'))->first();

        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));

        DB::table('zeiterfassung')
           ->where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'feierabend')
           ->delete();
    }

    public function getTime(Request $req)
    {
        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));
        $employee = employeeModel::where('user', $req->session()->get('username'))->first();

        $seconddate = date('Y-m-d H:i:s');
        $firstdate = date('Y-m-d H:i:s', strtotime('-'.date('H').' hours'));

        if ($employee != null) {
            $time = zeiterfassung::where('employee', $employee->id)->whereBetween('created_at', [$firstdate, $seconddate])->where('type', 'start')->first();
        } else {
            $time = 'awdawd';
        }

        return $time->created_at->format(' H:i');
    }

    public function getScannermodus(Request $req)
    {
        $state = $req->session()->get('scannermode');

        return $state;
    }

    public function setScannermodus(Request $req)
    {
        $char = allowBarcode::where('settingName', 'specialchar')->first();

        if ($req->input('mode') == null || $req->input('mode') == 'false') {
            $req->session()->put('scannermode', 'true');
            $req->session()->put('specialchar', $char->specialchar);
        } else {
            $req->session()->put('scannermode', 'false');
            $req->session()->put('specialchar', $char->specialchar);
        }

        return redirect('crm/packtisch');
    }

    public function changeProfile(Request $req, $id) {

        $file = $req->file("file");
        if($file != null) {
            if($file->getClientOriginalExtension() == "png" || $file->getClientOriginalExtension() == "jpg") {
                $file->storeAs("employee/". $id, "profile.png");
            } else {
                return redirect()->back()->withErrors(["Hochgeladene Bilder dürfen nur von folgendr Art sein: png, jpg"]);
            }
        }

        $user = auth()->user();
        
        $user->name = $req->input("name");
        if($req->input("username") != "") {
            $user->username = $req->input("username");
        }

        if($req->input("password") != "") {
            $user->password = Hash::make($req->input("password"));
        }

        if($req->input("email-input") != "") {
            $user->email = $req->input("email-input");
        }


        $user->update();

        return redirect()->back();

    }

    public function deleteProfilePicture(Request $req, $id) {

        try {
            Storage::delete('employee/'. $id. "/profile.png");
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(["Es Exestiert kein löschbares Profilbild"]);
        }

        return redirect()->back();

    }
}
