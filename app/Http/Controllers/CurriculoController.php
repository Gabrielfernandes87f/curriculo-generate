<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CurriculoController extends Controller
{
    public function downloadPdf($id)
    {



        $certification = Certification::find($id);
        
        $profissional = $certification->profissional ?: '';

        // Gerar o PDF com as informações do currículo
        $pdf = PDF::loadView('pdf', [
            'certification' => $certification,
            'profissional' => $profissional,
        ]);
        $pdf->render();

        // Salvar o PDF no sistema de arquivos
        $folder = 'curriculos';
        $relatorio = 'Gabriel1coder-curriculo';
        $pdfFile = $folder . '/' . $relatorio;

        try { 
            Storage::put('public/' . $pdfFile, $pdf->output());
            
            // Retornar o PDF como resposta HTTP para forçar o download
            return response()->file(storage_path('app/public/' .$pdfFile));
            } catch (\Exception $e) {
                return response('Erro ao gerar o PDF', 500);
            } 

            /*            
            # baixar logo o curriculo sem abrir antes. 
            return response()->download(storage_path('app/public/' . $pdfFile), 'curriculo.pdf'); 
           */
       
    }
}
