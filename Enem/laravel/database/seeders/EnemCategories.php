<?php

namespace Database\Seeders;

use App\Models\Taxonomy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnemCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seed = [
            'faixa_etaria' => $this->faixaEtaria(),
            'estado_civil' => $this->estadoCivil(),
            'cor_raca' => $this->corRaca(),
            'nacionalidade' => $this->nacionalidade(),
            'conclusao_ensino' => $this->conclusaoEnsino(),
            'tipo_escola' => $this->tipoEscola(),
            'presenca' => $this->presenca(),
        ];

        DB::transaction(function() use ($seed) {
            foreach ($seed as $s)
            {
                Taxonomy::insert($s);
            }
        });
    }

    private function presenca()
    {
        return [
            [
                'type' => 'presenca',
                'key' => 1,
                'value' => 'Faltou à prova',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'presenca',
                'key' => 2,
                'value' => 'Presente na prova',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'presenca',
                'key' => 3,
                'value' => 'Eliminado na prova',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function tipoEscola()
    {
        return [
            [
                'type' => 'tipo_escola',
                'key' => 1,
                'value' => 'Não respondeu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'tipo_escola',
                'key' => 2,
                'value' => 'Pública',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'tipo_escola',
                'key' => 3,
                'value' => 'Privada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function conclusaoEnsino()
    {
        return [
            [
                'type' => 'conclusao_ensino',
                'key' => 1,
                'value' => 'Já concluí o Ensino Médio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'conclusao_ensino',
                'key' => 2,
                'value' => 'Estou cursando e concluirei o Ensino Médio em 2022',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'conclusao_ensino',
                'key' => 3,
                'value' => 'Estou cursando e concluirei o Ensino Médio após 2022',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'conclusao_ensino',
                'key' => 4,
                'value' => 'Não concluí e não estou cursando o Ensino Médio',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function nacionalidade()
    {
        return [
            [
                'type' => 'nacionalidade',
                'key' => 0,
                'value' => 'Não informado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'nacionalidade',
                'key' => 1,
                'value' => 'Brasileiro(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'nacionalidade',
                'key' => 2,
                'value' => 'Brasileiro(a) Naturalizado(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'nacionalidade',
                'key' => 3,
                'value' => 'Estrangeiro(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'nacionalidade',
                'key' => 4,
                'value' => 'Brasileiro(a) Nato(a), nascido(a) no exterior',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function corRaca()
    {
        return [
            [
                'type' => 'cor_raca',
                'key' => 0,
                'value' => 'Não declarado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 1,
                'value' => 'Branca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 2,
                'value' => 'Preta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 3,
                'value' => 'Parda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 4,
                'value' => 'Amarela',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 5,
                'value' => 'Indígena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cor_raca',
                'key' => 6,
                'value' => 'Não dispõe da informação',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function estadoCivil()
    {
        return [
            [
                'type' => 'estado_civil',
                'key' => 0,
                'value' => 'Não informado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'estado_civil',
                'key' => 1,
                'value' => 'Solteiro(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'estado_civil',
                'key' => 2,
                'value' => 'Casado(a)/Mora com um(a) companheiro(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'estado_civil',
                'key' => 3,
                'value' => 'Divorciado(a)/Desquitado(a)/Separado(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'estado_civil',
                'key' => 4,
                'value' => 'Viúvo(a)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
    }

    private function faixaEtaria(): array
    {
        $faixa_etaria = [];

        for($i=1; $i<=2; $i++)
        {
            $faixa_etaria[] = [
                'type' => 'faixa_etaria',
                'key' => $i,
                'value' => 'Menor de 18 anos',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $idade = 18;
        for($i=3; $i<=10; $i++)
        {
            $faixa_etaria[] = [
                'type' => 'faixa_etaria',
                'key' => $i,
                'value' => $idade . ' anos',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $idade++;
        }

        $idade1 = 26;
        $idade2 = 30;
        for($i=11; $i<=19; $i++)
        {
            $faixa_etaria[] = [
                'type' => 'faixa_etaria',
                'key' => $i,
                'value' => "Entre $idade1 e $idade2 anos",
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $idade1 = $idade2+1;
            $idade2 = $idade1+4;
        }

        // Ultima opção
        $faixa_etaria[] = [
            'type' => 'faixa_etaria',
            'key' => 20,
            'value' => "Maior de 70 anos",
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return $faixa_etaria;
    }
}