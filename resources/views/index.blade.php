<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div class="container" style="width:400px; height: 400px; color: red; border-style: groove;float: left;">
            <div class="title" style="padding-left: 5%">
            </div>
            <form action="{{route('create')}}" method="post">
                @csrf
                <table style="width:100%;padding-left: 5%">
                    <tr>
                        <td>
                            <p>
                                Create Timesheet Entry
                                @foreach ($errors->all() as $err)
                                    <li>{{$err}}</li>
                                @endforeach
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date
                        </td>
                        <td>
                            <input type="date" name="Day">
                        </td>
                    </tr>
                    <tr>
                      <td>Start Time</td>
                      <td><input type="time" name="Start"></td>
                    </tr>
                    <tr>
                        <td>Finish Time</td>
                        <td><input type="time" name="Finish"></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" value="submit">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    
        <div class="container" style="width:400px; height: 400px; color: red; border-style: groove; float: left;">
            <table style="width:100%;padding-left: 5%">
                <tr>
                    <td>
                        <p>
                            Create Timesheet Entry
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        Timesheet Entries
                    </td>
                </tr>
                @foreach($data as $value)
                <tr>
                    <td>
                        <span class="Timesheet" style="color: black; font-weight: bold; font-size:">
                            {{$value->date.": ".date('H:i', strtotime($value->start_time)). ' - '.date('H:i', strtotime($value->finish_time)). ' $'.$value->amount}}
                        </span>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>