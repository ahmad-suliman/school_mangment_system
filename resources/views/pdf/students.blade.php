<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2{
            text-align: center;
            margin: 30px;
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
        table { width: 100%; border-collapse: collapse;}
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Student Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Classroom</th>
                <th>Section</th>
                <th>Birth Date</th>
                <th>Guardain Phone</th>
                <th>Date Of Join</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->classroom->class_name ?? '-' }}</td>
                    <td>{{ $student->classroom->section ?? '-' }}</td>
                    <td>{{ $student->birth_date ?? '-' }}</td>
                    <td>{{ $student->guardian_name . ': ' . $student->guardian_phone ?? '-' }}</td>
                    <td>{{ $student->created_at->format('d/m/y') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Generated at : {{now()}}
    </div>
</body>
</html>
