<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class PDFController extends Controller
{
    public function textToPdf()
    {
        return view('tools.pdf.text-to-pdf');
    }

    public function processTextToPdf(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'filename' => 'nullable|string'
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);

        $html = '<div style="font-family: Helvetica; padding: 40px; line-height: 1.6;">' . nl2br(e($request->text)) . '</div>';
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = ($request->filename ?: 'toolorbit-document') . '.pdf';

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function imageToPdf()
    {
        return view('tools.pdf.image-to-pdf');
    }

    public function processImageToPdf(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB Max
        ]);

        $image = $request->file('image');
        $base64 = base64_encode(file_get_contents($image->getRealPath()));
        $mime = $image->getMimeType();

        $options = new Options();
        $dompdf = new Dompdf($options);

        $html = '<div style="text-align:center; padding: 0; margin:0;">
                    <img src="data:' . $mime . ';base64,' . $base64 . '" style="max-width: 100%; height: auto;">
                 </div>';
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="toolorbit-image.pdf"');
    }

    public function pdfToBase64()
    {
        return view('tools.pdf.pdf-to-base64');
    }

    public function processPdfToBase64(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $pdf = $request->file('pdf');
        $base64 = 'data:application/pdf;base64,' . base64_encode(file_get_contents($pdf->getRealPath()));

        return response()->json([
            'base64' => $base64
        ]);
    }
}
