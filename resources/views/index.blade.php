<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <title>Document</title>
</head>
<body>
    <div class="main">
        <div class="timesheet timesheet_entry">
            <label for="" class="timesheet_entry--label">Create Timesheet Entry</label>
            <div class="timesheet_input">
                <label class="timesheet_input_label" for="">Date</label>
                <input type="date">
            </div>
            <div class="timesheet_input">
                <label class="timesheet_input_label" for="">Start Time</label>
                <input type="date">
            </div>
            <div class="timesheet_input">
                <label for="" class="timesheet_input_label">Finish Time</label>
                <input type="date">
            </div>
            <div class="timesheet_input">
                <button type="submit" class="timesheet_input--submit">create</button>
            </div>
        </div>
        <div class="timesheet timesheet_entries">
            <button class="timesheet_entries_input">Create Timesheet Entry</button>
            <div>
                <label for="" class="timesheet_entries--label">Create Timesheet Entry</label>
            </div>
            <div class="timesheet_result">
                <p>dsadadasdad</p>
            </div>
        </div>
    </div>
</body>
</html>