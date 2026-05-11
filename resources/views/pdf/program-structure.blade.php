
<!DOCTYPE html>
<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2 f2 f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
    
<body>
    <div class="header">
        <h1>Program Structure: {{ $title }}</h1>
        <p>Date: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Semester</th>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Credit Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($structure->programSubjects->groupBy('semester_number') as $semNum => $subs)
                @foreach($subs as $pSub)
                    <tr>
                        <td>{{ $semNum }}</td>
                        <td>{{ $pSub->subject->subject_code }}</td>
                        <td>{{ $pSub->subject->subject_name }}</td>
                        <td>{{ $pSub->subject->credit_hours }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
</table>
</body>
</html>