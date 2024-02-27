<?php

namespace App\Http\Controllers;

use App\Models\Enem;
use Illuminate\Http\Request;

class EnemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('csv_file')) {
            return $this->uploadAndSaveCSV($request->file('csv_file'));
        }

        return response()->json(['error' => 'Nenhum arquivo enviado']);
    }

    public function uploadAndSaveCSV($filePath = null, $truncate = false)
    {
        if(empty($filePath))
            return ['message' => 'Nenhum arquivo enviado']);

		// Remover o limite de memória (não recomendado em produção)
		ini_set('memory_limit', '-1');

        if(!is_string($filePath))
        {
            $filePath = $filePath->getRealPath();
        }

        // Configure o tamanho do chunk, por exemplo, 100 MB
        $chunkSize = 250 * (1024 * 1024);

        // Abra um stream para o arquivo no disco
        $stream = fopen($filePath, 'r');

        // Pule a primeira linha se ela contiver cabeçalhos
        fgetcsv(
            stream: $stream,
            separator: ';'
        );

        // Limpa a base completamente
        if($truncate)
            Enem::truncate();

        $totalPercorrido = 0;
        $salvos = 0;
        $errors = [];

        // Percorra o arquivo CSV em chunks até seu fim
        while (!feof($stream)) {
            // Leia um chunk do stream
            $chunk = fread($stream, $chunkSize);

            // Divida o chunk em linhas
            $linhas = explode("\n", $chunk);

            foreach ($linhas as $linha) {
                // Ignore linhas em branco
                if (!empty($linha)) {
                    // Transforme a linha CSV em array associativo
                    $dados = str_getcsv($linha, separator: ';');

                    // Salve os dados no banco de dados e ignore os erros que derem (como duplicatas), realizando o update na linha existente
                    try {
                        Enem::updateOrCreate([
                            'nu_inscricao' => $dados[0]
                        ],[
                            'nu_inscricao' => $dados[0],
                            'faixa_etaria' => $dados[2],
                            'sexo' => $dados[3],
                            'estado_civil' => $dados[4],
                            'conclusao_ensino_medio' => $dados[7],
                            'tipo_escola' => $dados[9],
                            'uf' => $dados[15],
                            'cidade' => mb_convert_encoding($dados[20], 'UTF-8', 'latin1'),
                            'escolaridade_pai' => $dados[51],
                            'escolaridade_mae' => $dados[52],
                            'ocupacao_pai' => $dados[53],
                            'ocupacao_mae' => $dados[54],
                            'numero_pessoas_em_casa' => $dados[55],
                            'renda_familiar_mensal' => $dados[56],
                            'possui_celular_em_casa' => $dados[72],
                            'possui_computador_em_casa' => $dados[74],
                            'acesso_internet_em_casa' => $dados[75],
                            'lingua' => $dados[39],
                            'presenca_cn' => $dados[23],
                            'presenca_ch' => $dados[24],
                            'presenca_lc' => $dados[25],
                            'presenca_mt' => $dados[26],

                            //Adicionando ZERO para quem não realizou o teste no dia
                            'nota_cn' => $dados[31] ?: 0,
                            'nota_ch' => $dados[32] ?: 0,
                            'nota_lc' => $dados[33] ?: 0,
                            'nota_mt' => $dados[34] ?: 0,

                            'nota_redacao' => $dados[50] ?: 0,

                            'nota_comp1' => $dados[45] ?: 0,
                            'nota_comp2' => $dados[46] ?: 0,
                            'nota_comp3' => $dados[47] ?: 0,
                            'nota_comp4' => $dados[48] ?: 0,
                            'nota_comp5' => $dados[49] ?: 0
                        ]);

                        $salvos++;
                    }
                    catch (\Exception $e)
                    {
                        $errors[] = $e->getMessage() . ' [Linha CSV: '. ($totalPercorrido+1) .'] [Linha Cod.: ' . $e->getLine() . ']';
                    }
                }

                $totalPercorrido++;
            }

            // Limpe a memória do PHP para evitar estouro
            try{
				flush();
				ob_flush();
			}
			catch (\Exception $e){}
		}

        // Feche o stream
        fclose($stream);

        return [
            'lines' => $salvos,
            'errors' => $errors,
            'message' => 'Upload e salvamento no banco de dados concluídos com sucesso'
        ];
    }
}
