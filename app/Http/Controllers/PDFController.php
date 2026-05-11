<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStructure;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        // Logic to generate PDF
        $structure = ProgramStructure::with('programSubjects.subject')->findOrFail($id); // Fetch the program structure by ID

        $data = [
            'title' => 'Program Structure:'. $structure->program_structure_name,
            'date' => date('m/d/Y'),
            'structure' => $structure,
        ];
        // You can use a package like Dompdf or Snappy to create PDFs in Laravel
        // Example using Dompdf:
        $pdf = Pdf::loadView('pdf.program-structure', $data); // Load a view for the PDF content
        $fileName= str_replace(' ', '_', $structure->program_structure_name) . '.pdf'; // Create a filename based on the structure name
        return $pdf->download($fileName); // Download the generated PDF
    }
}
