<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Processo parte da Limpeza de dados
     *  A limpeza de dados é necessária para performar a análise exploratória de dados. Dado o alto volume de dados e a sua origem (dados reais), algumas tarefas devem ser realizadas.
     *  - Criaremos a tabela principal onde vamos salvar somente os dados que precisamos
     *  - Vamos remover as colunas não úteis
     *  - Criar os campos com os tipos de dados corretos para diminuir o espaço utilizado
     */
    public function up(): void
    {
        /**
         * Tabela principal
         * Somente as colunas necessárias
         */
        Schema::create('enem', function (Blueprint $table) {
            $table->id();

            // Chave única para garantir que não tenha itens repetidos e ~NULL
            $table->unsignedBigInteger('nu_inscricao')->unique();

            $table->tinyInteger('faixa_etaria')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->tinyInteger('estado_civil')->nullable();
            $table->tinyInteger('cor_raca')->nullable();
            $table->tinyInteger('conclusao_ensino_medio')->nullable();
            $table->tinyInteger('tipo_escola')->nullable();

            $table->string('uf', 2)->nullable();
            $table->string('cidade', 255)->nullable();

            $table->string('escolaridade_pai', 1)->nullable(); #q001
            $table->string('escolaridade_mae', 1)->nullable(); #q002
            $table->string('ocupacao_pai', 1)->nullable(); #q003
            $table->string('ocupacao_mae', 1)->nullable(); #q004
            $table->tinyInteger('numero_pessoas_em_casa')->nullable(); #q005
            $table->string('renda_familiar_mensal', 1)->nullable(); #q006
            $table->string('possui_celular_em_casa', 1)->nullable(); #q022
            $table->string('possui_computador_em_casa', 1)->nullable(); #q024
            $table->string('acesso_internet_em_casa', 1)->nullable(); #q025

            $table->tinyInteger('lingua')->nullable();

            $table->tinyInteger('presenca_cn')->nullable();
            $table->tinyInteger('presenca_ch')->nullable();
            $table->tinyInteger('presenca_lc')->nullable();
            $table->tinyInteger('presenca_mt')->nullable();

            $table->float('nota_ch', 4)->default(0);
            $table->float('nota_cn', 4)->default(0);
            $table->float('nota_lc', 4)->default(0);
            $table->float('nota_mt', 4)->default(0);
            $table->float('nota_redacao', 4)->default(0);
            $table->float('nota_comp1', 4)->default(0);
            $table->float('nota_comp2', 4)->default(0);
            $table->float('nota_comp3', 4)->default(0);
            $table->float('nota_comp4', 4)->default(0);
            $table->float('nota_comp5', 4)->default(0);

            $table->timestamps();
        });

        /**
         * Vamos criar uma tabela genérica para guardar a descrição dos campos, que serão utilizado posteriormente
         * O "de x para" dos dados podem ser encontrados aqui:
         * microdados_enem_2022/INPUTS/INPUT_R_MICRODADOS_ENEM_2022.R
         */
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();

            $table->enum('type', [
                'faixa_etaria',
                'estado_civil',
                'cor_raca',
                'nacionalidade',
                'conclusao_ensino',
                'tipo_escola',
                'presenca',
                'renda_familiar',
                'lingua',
            ]);

            $table->string('key', 3);// Pode ser um número ou uma letra, dependendo da coluna na tabela principal
            $table->string('value', 255);

            // Chave única para garantir que não tenha itens repetidos
            $table->unique(['type', 'key']);

            $table->timestamps();
        });

        /**
         * Aqui teremos apenas os nomes dos estados para usar no gráfico de mapa
         */
        Schema::table('estados', function (Blueprint $table) {
            $table->dropColumn('nome');
            $table->dropColumn('abreviacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enem');
        Schema::dropIfExists('taxonomy');
        Schema::dropIfExists('estados');
    }
};
