<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ReportPdfController extends Controller
{
     use AuthorizesRequests;

    public function exportStudentsPdf()
    {
        $this->authorize('viewAny', Student::class);

        $students = Student::with(['user', 'classroom'])->get();

        $pdf = Pdf::loadView('pdf.students', compact('students'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('students-report.pdf');
    }

    public function exportStudentPdf(Student $student)
    {
        $this->authorize('view', $student);

        $student->load(['user', 'classroom', 'grades', 'attendances']);

        $pdf = Pdf::loadView('pdf.student-report', [
            'student'    => $student,
            'reportDate' => now()->format('Y-m-d'),
        ]);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('student-' . $student->student_id . '-report.pdf');
    }
}
