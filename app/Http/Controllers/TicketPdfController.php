<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class TicketPdfController extends Controller
{
    public function pdf($ticket)
    {
        $url = route('tickets.print.preview', ['ticket' => $ticket]);

        $headerHtml = view('partials.print_header')->render();
        $footerHtml = view('partials.print_footer')->render();

        $pdf = Browsershot::url($url)
            ->noSandbox()
            ->showBackground()
            ->format('A4')
            ->margins(10, 12, 20, 12) // top,right,bottom,left in mm (reduced to allow page CSS to control spacing)
            ->setOption('displayHeaderFooter', true)
            ->setOption('headerTemplate', '<div style="width:100%;font-size:10px;margin:0 auto;">' . addcslashes($headerHtml, "\n\r") . '</div>')
            ->setOption('footerTemplate', '<div style="width:100%;font-size:10px;margin:0 auto;">' . addcslashes($footerHtml, "\n\r") . '</div>')
            ->setOption('footerTemplate', $footerHtml)
            ->pdf();

        return response($pdf, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=ticket_{$ticket}.pdf");
    }
}
