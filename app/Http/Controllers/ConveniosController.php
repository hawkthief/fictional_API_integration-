<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class ConveniosController extends Controller
{
    public function index()
    {
        $path = storage_path('app/data/convenios.json');

        if (!file_exists($path)) {
            return response()->json(['error' => 'Arquivo não encontrado', 'caminho' => $path], 404);
        }

        $json = file_get_contents($path);
        $dados = json_decode($json, true);

        $resultado = [];
        foreach ($dados as $chave => $valor) {
            $resultado[]  = [
                'chave' => (string) $chave,
                'valor' => $valor
            ];
        }

        return response()->json($resultado);
    }
}
