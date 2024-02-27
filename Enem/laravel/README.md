Fazer o upload de arquivos grandes sem sobrecarregar a memória do servidor é uma boa prática. Uma abordagem comum é usar o método de "streaming" para ler e salvar o arquivo em partes, evitando carregar o arquivo inteiro na memória.

Para isso precisamos ter nosso ambiente configurado com os arquivos necessários:

### Iniciando o projeto:
1) Instalar o **Laravel**. Execute o comando abaixo para iniciar um novo projeto do Laravel:
   `composer create-project --prefer-dist laravel/laravel laravel`
    - Você vai precisar do Composer instalado: [Composer (getcomposer.org)](https://getcomposer.org/download/)
2) Acesse a pasta do Laravel (no Prompt/Terminal) e execute o comando para iniciar o servidor PHP:
   `php artisan serve`
    - Acesse o servidor em: [http://127.0.0.1:8000](http://127.0.0.1:8000/)
3) Faça as configurações prévias de um projeto Laravel: Crie a base no banco que irá utilizar, adicione as credenciais e o nome do banco no arquivo `.env`

### Criando os arquivos necessários:
1) Crie o **Controller** e o **Model**
   `php artisan make:controller`
    1) Vai ser perguntado o nome do Controller: `EnemController`
    2) Vai ser perguntado qual o tipo: `resource`
    3) Vai ser perguntado se já tem um Model para associar. Adicione o nome: `Enem`
        - Vai ser questionado que não tem um Model com esse nome. Digite `yes` ou aperte enter para criar o model
2) Crie uma **[Migration](https://laravel.com/docs/10.x/migrations)**, que será responsável por criar a tabela no banco, que irá guardar os dados do arquivo CSV
3) Crie um comando para executar o metodo que iremos criar: `php artisan make:command UploadBaseEnem`
   - Adicione o comando criado no arquivo `app/Console/Kernel.php`:
   - Execute o comando com `php artisan base:up C:\path_to_file\....`
```php
protected $commands = [
    \App\Console\Commands\UploadBaseEnem::class,
];
```

### Codificando:

Comando:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\EnemController;

class UploadBaseEnem extends Command
{
    protected $signature = 'upload:executar';
    protected $description = 'Realizar upload da base do Enem para o banco de dados configurado';

    public function handle()
    {
        $controller = new EnemController(); // Substitua pelo nome do seu controlador
        $controller->uploadAndSaveCSV();
        $this->info('Método executado com sucesso!');
    }
}

```

Migration:
```php

```

Controller:
```php
use Illuminate\Http\Request;
use App\Models\Enem; // O seu Model

public function uploadAndSaveCSV(Request $request)
{
    if ($request->hasFile('csv_file')) {
        $csvFile = $request->file('csv_file');

        $filePath = $csvFile->getRealPath();
        $fileSize = $csvFile->getSize();

        // Configure o tamanho do chunk, por exemplo, 1 MB
        $chunkSize = 1024 * 1024;

        // Abra um stream para o arquivo no disco
        $stream = fopen($filePath, 'r');

        // Pule a primeira linha se ela contiver cabeçalhos
        fgetcsv($stream);

        // Percorra o arquivo CSV em chunks
        while (!feof($stream)) {
            // Leia um chunk do stream
            $chunk = fread($stream, $chunkSize);

            // Divida o chunk em linhas
            $linhas = explode("\n", $chunk);

            foreach ($linhas as $linha) {
                // Ignore linhas em branco
                if (!empty($linha)) {
                    // Transforme a linha CSV em array associativo
                    $dados = str_getcsv($linha);

                    // Salve os dados no banco de dados
                    Enem::create([
                        'coluna1' => $dados[0], // Substitua 'coluna1' pelos nomes reais das suas colunas
                        'coluna2' => $dados[1],
                        // Adicione mais colunas conforme necessário
                    ]);
                }
            }

            // Limpe a memória do PHP para evitar estouro
            flush();
            ob_flush();
        }

        // Feche o stream
        fclose($stream);

        return response()->json(['message' => 'Upload e salvamento no banco de dados concluídos com sucesso']);
    }

    return response()->json(['error' => 'Nenhum arquivo enviado']);
}
```

Neste exemplo, o arquivo é aberto como um stream e salvo em partes usando o método `put` do Storage. Isso permite que você gerencie arquivos grandes sem consumir muita memória.

Lembre-se de configurar o `upload_max_filesize` e `post_max_size` no arquivo `php.ini` do seu servidor para acomodar o tamanho do arquivo que você está tentando enviar. E ajuste os limites de tempo de execução, se necessário (`max_execution_time` e `max_input_time`).
