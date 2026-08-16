<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2{
            text-align: center;
            margin-bottom: 30px;
        }
        h3{
            text-align: center;
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: right;
        }

        th {
            background-color: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="footer">Report date: {{ $reportDate }}</div>


    <h2>Student Report — {{ $student->student_id }}</h2>
    <p><b>Full Name:</b>{{ $student->user->name ?? '-' }}</p>
    <p><b>Class:</b> {{ $student->classroom->class_name ?? '-' }}</p>
    <p><b>Section:</b> {{ $student->classroom->section ?? '-' }}</p>
    <p><b>Email:</b> {{ $student->user->email ?? '-' }}</p>
    <p><b>Phone Number:</b> {{ $student->phone ?? '-' }}</p>
    <p><b>Guardian Name:</b> {{ $student->guardian_name ?? '-' }}</p>
    <p><b>guardian Number:</b> {{ $student->guardian_phone ?? '-' }}</p>
    <p><b>Join Date:</b> {{ $student->created_at->format('Y/m/d') ?? '-' }}</p>
    <h3>Grades</h3>
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student->grades as $grade)
                <tr>
                    <td>{{ $grade->subject->subject_name ?? '-' }}</td>
                    <td>{{ $grade->marks ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
     @if($student->attendances)
    <h3>Attendance</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student->attendances as $attendance)
                <tr>
                    <td>{{ $attendance->date ?? '-' }}</td>
                    <td>{{ $attendance->status ?? '-' }}</td>
                </tr>
            @endforeach

        @endif

        </tbody>
    </table>

</body>

</html>
