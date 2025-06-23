<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class DemoSSTIController extends Controller
{
    public function showForm()
    {
        return view('ssti.form');
    }

    public function renderTemplate(Request $request)
    {
        $template = $request->input('template');
        // Biên dịch nội dung Blade thành PHP
        $compiled = Blade::compileString($template);
        // Bắt output đầu ra
        ob_start();
        eval('?>' . $compiled);
        $output = ob_get_clean();
        return view('ssti.result', [
            'template' => $template,
            'output' => $output,
        ]);
    }

}
