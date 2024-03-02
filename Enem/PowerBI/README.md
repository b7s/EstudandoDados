Essa análise é realizada no Power BI para ganhar tempo e ter maior praticidade na criação dos visuais, além disso, possibilitando filtros avançados e combinações complexas de filtros para o usuário final, caso ele ache necessário, abrindo um leque gigante de possibilidades de análises, saíndo das análises básicas e demoradas feitas apenas via código.

## Análise
A principal avaliação deve ser feita na **nota geral** (chamada de **nota média** no dashboard do Power BI), ela é a média de 5 notas: Linguagens, Ciências Humanas, Ciências da Natureza, Matemática e Redação. A análise da nota será feita somente para os que compareceram nos dois dias de provas, evitando os valores nulos.

Com essa análise poderemos responder algumas perguntas:
- Qual a diferença entre faixa etária?
- Qual a diferença por renda?
- O sexo influencia em algo?
- Qual o resultado por estado?
- A escolaridade dos país influenciam?
- A fala de computado, celular ou internet influencia?

### Sobre os dados
Os [microdados](https://www.gov.br/inep/pt-br/acesso-a-informacao/dados-abertos/microdados/enem) são os dados mais detalhados coletados em pesquisas, avaliações e exames, como no caso do ENEM, onde cada participante é representado. Nos dados divulgados, não há informações que permitam identificar diretamente o participante, como nome, endereço, e-mail, CPF ou data de nascimento. Até mesmo o número real de inscrição é substituído por uma máscara gerada sequencialmente. Em resumo, são dados anonimizados.


## Passos no Power BI
1) Adicionar a tabela principal do `enem` (fato), tabela `taxonomies` (dimensão) e tabela de `estados` (dimensão)
2) Criar os relacionamentos das categorias
    - Para isso, vamos adicionar a tabela `Taxonomies` e criar referências dela (usando o Power Query) para cada categoria (confira no arquivo como ficou), servindo como tabelas `Dimensão`. Isso elimina a necessidade de ter várias conexões ativas com o banco, puxando os dados apenas uma vez, é útil quando se pretende ter uma base atualizando várias vezes.
    - Faça os relacionamentos de cada tabela dimensão (taxonomias) com a tabela fato (enem) na sua coluna respectiva
    - Para mais detalhes, baixe o arquivo do Power BI

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/analise-enem-22/relacionamentos.png" alt="relacionamentos">
</p>

3) Algumas coisas foram criadas para análise 
    1) Colunas:
        1) Presença: irá validar se o candidato estava presente nos dois dias da prova (colunas: presenca_cn, presenca_ch, presenca_lc, presenca_mt)
        2) Nota média: irá calcular a nota média geral de cada candidato com base em 5 colunas (colunas: nota_ch, nota_cn, nota_lc, nota_mt, nota_redacao)
        3) Categoria da nota: deve conter uma série numérica de 100 em 100 de acordo com a média das notas. Ex: Se a nota foi 54,90, a categoria da nota será 0 (zero), se foi 678,97, será 600.
    2) Medidas: Cálculo da nota média (usando a coluna acima), nota máxima, mínima, presença e representatividade
4) Análise univariada: Criada uma página que irá comportar os gráficos da análise de desempenho. Aqui podemos entender melhor quais gráficos usar e quais dados vamos exibir


### Calculando
Vou exemplificar aqui alguns calculos, mas você pode conferir todos no arquivo. Como a base apesar de grande não é complexa, os calculos são relativamente simples. Confira alguns abaixo.

#### Coluna: de nota média
Vamos somar e dividir por 5 todas as colunas referentes as notas das avaliações (incluíndo a redação). É possivel fazer diretamente em uma medida, mas isso facilita na criação da categorização e nos outros calculos. 
Adicione uma coluna na tabela `fato_enem` com o código abaixo:

```php
// Coluna
nota média = DIVIDE(
    'fato_enem'[nota_ch] + 
    'fato_enem'[nota_cn] + 
    'fato_enem'[nota_lc] + 
    'fato_enem'[nota_mt] + 
    'fato_enem'[nota_redacao],
    5
)
```

#### Coluna: Categoria da Nota
Criando uma série de 100 em 100 com base na nota e agrupa ela nesse intervalo entr o x00 e x99

```php
// Coluna
Categoria da Nota = ROUNDDOWN(DIVIDE([nota média], 100), 0) * 100
```

#### Nota média
Vamos forçar calcular somente a média de quem esteve presente nos dois dias de prova. Para isso usa-se o filtro `fato_enem[presente] = 1`. Calculamos a média usando a coluna criada acima.

```php
// Medida
Nota média = CALCULATE(
    AVERAGE(fato_enem[nota média]),
    fato_enem[presente] = 1
)
```

## Resultado 

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/analise-enem-22/visual_geral_dash_enem.png" alt="">
</p>

Com o dash, foi possivel concluir que:
**Positivamente:**
- Quanto maior a renda, melhor a nota
- Pessoas com menos de 18 anos tem desempenho superior
- Ensino médio recem concluído

**Negativamente:**
- A idade entre 35 e 65 são as que levam a nota média geral para baixo
- Alunos de escola pública tem um desempenho mais baixo
- Família sem renda ou com renda de até um salário mínimo (da época), também tem desempenho inferior
- Não finalizou o ensino médio ou já finalizado há mais tempo

### Visuais dinâmicos
Os visuais utilizados possibilitam análise automáticas ou mesmo análises manuais, onde você pode combinar filtros apenas clicando nas colunas desejadas ou aplicando os filtros disponíveis no dash.

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/analise-enem-22/arvore-decomposicao.png" alt="">
</p>

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/analise-enem-22/graficos-gerais.png" alt="">
</p>

----

**O arquivo completo do Power BI (visual + dados) pode ser baixado no link**: https://1drv.ms/u/s!Alu3NT3bt007gtkhk1jKtNRmeev-nw?e=3wCnQo
