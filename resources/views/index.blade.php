<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <title>Timesheet</title>
</head>
<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="main">
        <form action="{{route('create')}}" method="post">
            @csrf
            <div class="timesheet timesheet_entry">
                <label for="" class="timesheet_entry--label">Create Timesheet Entry</label>
                <div class="timesheet_input">
                    <label class="timesheet_input_label" for="">Date</label>
                    <input type="date" name="day">
                </div>
                <div class="timesheet_input">
                    <label class="timesheet_input_label" for="">Start Time</label>
                    <input type="time" name="start_time">
                </div>
                <div class="timesheet_input">
                    <label for="" class="timesheet_input_label">Finish Time</label>
                    <input type="time" name="finish_time">
                </div>
                <div class="timesheet_input">
                    <input type="submit" class="timesheet_input--submit" value="Create">
                </div>
            </div>
        </form>
        <div class="timesheet timesheet_entries">
            {{-- <button class="timesheet_entries_input">Create Timesheet Entry</button> --}}
            <div>
                <label for="" class="timesheet_entries--label">Create Timesheet Entry</label>
            </div>
            <div class="timesheet_result">
                @if (App\Models\Time::count() > 0)
                    @foreach (App\Models\Time::all() as $time)
                        <p>{{$time->date}}: {{date('H:i', strtotime($time->start))}} - {{date('H:i', strtotime($time->finish))}} ${{$time->amount}}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</body>
</html>