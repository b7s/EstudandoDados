<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosBrasileiros extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nome' => 'Acre', 'abreviacao' => 'AC'],
            ['nome' => 'Alagoas', 'abreviacao' => 'AL'],
            ['nome' => 'Amapa', 'abreviacao' => 'AP'],
            ['nome' => 'Amazonas', 'abreviacao' => 'AM'],
            ['nome' => 'Bahia', 'abreviacao' => 'BA'],
            ['nome' => 'Ceara', 'abreviacao' => 'CE'],
            ['nome' => 'Distrito Federal', 'abreviacao' => 'DF'],
            ['nome' => 'Espirito Santo', 'abreviacao' => 'ES'],
            ['nome' => 'Goias', 'abreviacao' => 'GO'],
            ['nome' => 'Maranhao', 'abreviacao' => 'MA'],
            ['nome' => 'Mato Grosso', 'abreviacao' => 'MT'],
            ['nome' => 'Mato Grosso do Sul', 'abreviacao' => 'MS'],
            ['nome' => 'Minas Gerais', 'abreviacao' => 'MG'],
            ['nome' => 'Para', 'abreviacao' => 'PA'],
            ['nome' => 'Paraiba', 'abreviacao' => 'PB'],
            ['nome' => 'Parana', 'abreviacao' => 'PR'],
            ['nome' => 'Pernambuco', 'abreviacao' => 'PE'],
            ['nome' => 'Piaui', 'abreviacao' => 'PI'],
            ['nome' => 'Rio de Janeiro', 'abreviacao' => 'RJ'],
            ['nome' => 'Rio Grande do Norte', 'abreviacao' => 'RN'],
            ['nome' => 'Rio Grande do Sul', 'abreviacao' => 'RS'],
            ['nome' => 'Rondonia', 'abreviacao' => 'RO'],
            ['nome' => 'Roraima', 'abreviacao' => 'RR'],
            ['nome' => 'Santa Catarina', 'abreviacao' => 'SC'],
            ['nome' => 'Sao Paulo', 'abreviacao' => 'SP'],
            ['nome' => 'Sergipe', 'abreviacao' => 'SE'],
            ['nome' => 'Tocantins', 'abreviacao' => 'TO'],
        ];

        DB::table('estados')->insert($estados);
    }
}
