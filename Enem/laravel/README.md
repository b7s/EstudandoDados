O código criado em PHP (Laravel) é responsável por subir a base de microdados do Enem de 2022 para o banco de dados MySQL (nesse exemplo), via linha de comando. A base oficial pode ser encontrada no link: [Enem — Instituto Nacional de Estudos e Pesquisas Educacionais Anísio Teixeira | Inep (www.gov.br)](https://www.gov.br/inep/pt-br/acesso-a-informacao/dados-abertos/microdados/enem),

----

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

```shell
php artisan make:controller 
```

- Vai ser perguntado o nome do Controller: `EnemController`
- Vai ser perguntado qual o tipo: `resource`
- Vai ser perguntado se já tem um Model para associar. Adicione o nome: `Enem`
    - Vai ser questionado que não tem um Model com esse nome. Digite `yes` ou aperte _enter_ para criar o model

2) Crie uma **[Migration](https://laravel.com/docs/10.x/migrations)**, que será responsável por criar a tabela no banco, que irá guardar os dados do arquivo CSV
3) Crie um comando para executar o metodo que iremos criar:
    `php artisan make:command UploadBaseEnem`
   - Adicione o comando criado no arquivo `app/Console/Kernel.php`:
```php
protected $commands = [
    \App\Console\Commands\UploadBaseEnem::class,
];
```
   - Execute no terminal o comando com `php artisan base:up C:\path_to_file\...`
	   - Existe uma opção específica que pode ser usada para limpar a base principal antes de subir os dados: `--truncate`
4) Vamos criar um arquivo de _Seed_ para inserir as categorias no banco.
> Aqui escolhi criar uma única tabela - chamada 'Taxonomies' - para guardar as categorias, mas, poderia criar uma tabela para cada uma para trabalhar no modelo estrela no Power BI ou outra ferramenta. 
```shell
# Criando o arquivo
php artisan make:seeder EnemCategories
# (Confira o código usado abaixo)
```
```shell
# Executar a seed
php artisan db:seed --class=EnemCategories
```
5) Vamos criar uma tabela para guardar os nomes complestos dos estados brasileiros, usaremos eles no visual de mapa para preencher as cores de cada estado. Importante: Os nomes não podem conter acentuação ou o gráfico do Power BI não reconhecerá.
```shell
# Criando o arquivo
php artisan make:seeder EstadosBrasileiros
# (Confira o código usado abaixo)
```
```shell
# Executar a seed
php artisan db:seed --class=EstadosBrasileiros
```

### O código usado:

- Migration: [2024_02_27_004312_create_enem_table.php](https://github.com/b7s/EstudandoDados/blob/main/Enem/laravel/database/migrations/2024_02_27_004312_create_enem_table.php)
- Controller: [EnemController.php](https://github.com/b7s/EstudandoDados/blob/main/Enem/laravel/app/Http/Controllers/EnemController.php)
- Seeds criadas: [Veja todas](https://github.com/b7s/EstudandoDados/blob/main/Enem/laravel/database/seeders/)
- Comando (console): [UploadBaseEnem.php](https://github.com/b7s/EstudandoDados/blob/main/Enem/laravel/app/Console/Commands/UploadBaseEnem.php)

----

### Informações úteis

#### Controller

No código do **controller**, o arquivo é aberto como um stream e salvo em partes (_chunks_) usando `updateOrCreate`. Isso permite que você gerencie arquivos grandes sem consumir muita memória.

Lembre-se de configurar o `memory_limit` caso precise processar mais dados de uma vez.
```php
ini_set('memory_limit', '-1');
```

Se precisar, ajuste os limites de tempo de execução, se necessário (`max_execution_time`).

Configure o chunk que deve ser processado por vez:
```php
// Configure o tamanho do chunk, por exemplo, 250 MB (isso afeta a memória RAM utilizada)
$chunkSize = 250 * (1024 * 1024);
```

#### Seed (Taxonomies)

Conforme você pode conferir na Migration, a tabela de _Taxonomia_ tem como chave única as colunas `type` e `key` de forma conjunta, evitando duplicidade e podendo ser usada para realizar o JOIN em eventual query.

