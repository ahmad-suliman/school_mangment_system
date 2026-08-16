<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPdfController extends Controller
{
    public function exportStudentsPdf()
    {
        $students = Student::with(['user','classroom'])->get();
        $pdf = Pdf::loadView('pdf.students', compact('students'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('students-report.pdf');

        //to view the pdf in browser
        //return $pdf->stream('students-report.pdf');

    }
    public function exportStudentPdf(Student $student){
        $student->load(['user', 'classroom', 'grades', 'attendances']);
            $pdf = Pdf::loadView('pdf.student-report', [
            'student'    => $student,
            'reportDate' => now()->format('Y-m-d'),
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('student-' . $student->student_id . '-report.pdf');

    }
}
