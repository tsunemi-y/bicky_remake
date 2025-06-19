<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF as DomPDF;

class FileService
{
    public function delete($fileName)
    {
        unlink(storage_path($fileName));
    }

    public function putPDF($param, $view, $fileName)
    {
        $pdf = app(DomPDF::class);
        $pdf->loadView($view, $param);
        $downloadedPdf = $pdf->output();
        file_put_contents(storage_path($fileName), $downloadedPdf);
    }

    public function putRequestedFile($request, $fileName)
    {
        $request->file('file')->storeAs('', $fileName);
    }
}
