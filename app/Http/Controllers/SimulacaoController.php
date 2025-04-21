<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulacaoController extends Controller
{
    public function simular(Request $request)
    {
        $request->validate([
            'valor_emprestimo' => 'required|numeric|min:0.01',
            'instituicoes' => 'array|nullable',
            'convenios' => 'array|nullable',
            'parcela' => 'integer|nullable'
        ]);

        $valor = $request->input('valor_emprestimo');
        $instituicoesFiltro = $request->input('instituicoes', []);
        $conveniosFiltro = $request->input('convenios', []);
        $parcelaFiltro = $request->input('parcela');

        $instituicoes = $this->readJsonFile('instituicoes.json');
        $convenios = $this->readJsonFile('convenios.json');
        $taxas = $this->readJsonFile('taxas.json');

        $resultado = [];

        foreach ($taxas as $taxa) {
            $instituicaoId = $taxa['instituicao_id'];
            $convenioId = $taxa['convenio_id'];
            $parcelas = $taxa['parcelas'];
            $coeficiente = $taxa['coeficiente'];

            if (
                (!empty($instituicoesFiltro) && !in_array($instituicaoId, $instituicoesFiltro)) ||
                (!empty($conveniosFiltro) && !in_array($convenioId, $conveniosFiltro)) ||
                ($parcelaFiltro !== null && $parcelas != $parcelaFiltro)
            ) {
                continue;
            }

            $valorParcela = round($valor * $coeficiente, 2);
            $taxaPercentual = round($coeficiente * 100, 2);

            $resultado[$instituicaoId]['instituicao'] = $instituicoes[$instituicaoId] ?? 'Desconhecida';
            $resultado[$instituicaoId]['opcoes'][] = [
                'taxa' => $taxaPercentual,
                'parcelas' => $parcelas,
                'valor_parcela' => $valorParcela,
                'convenio' => $convenios[$convenioId] ?? 'Desconhecido'

            ];
        }

        return response()->json(array_values($resultado));
    }

    private function readJsonFile(string $filename)
    {
        $path = storage_path('app/data/' . $filename);

        if (!file_exists($path)) {
            abort(500, "Arquivo $filename não encontrado em $path");
        }

        $content = file_get_contents($path);
        return json_decode($content, true);
    }
}
