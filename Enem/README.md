Esse é projeto de dados que engloba todas as fases, desde a coleta até o deploy. Focado na limpeza, análise exploratória e modelagem dos microdados do Enem 2022, utilizando dados públicos reais. A estruturação da solução segue o framework CRISP-DM, incluindo a compreensão do problema, análise dos dados, limpeza, modelagem e deploy.

As análises podem ajudar a identificar os fatores e como a nota do candidato é impactada. Conseguindo identificar talentos escondidos e necessidades individuais para direcionar melhor os recursos e as estratégias para reduzir os impactos no ensino.

## Fases

1) **Limpeza dos dados**: Parte essencial, visto que temos uma base de passa dos 2 GB em sua base principal, mais várias bases menores de categoria (chamada aqui de taxonomia).

2) **Análise e modelagem de desempenho**: Objetiva identificar as principais variáveis que impactam a nota do candidato, sua relação com o desempenho e como podem ser usadas na predição. Para isso, utiliza-se um modelo de Regressão Lasso.

### 1. Coleta

A coleta dos microdados precisa ser feita no site oficial do governo federal ([baixe aqui](https://www.gov.br/inep/pt-br/acesso-a-informacao/dados-abertos/microdados/enem)).

O arquivo baixado consiste em um _.zip_ com vários arquivos em .pdf, .csv, .r. Temos as provas, os resultados das provas, arquivos de input em .R e arquivos com os dados consolidados, em .csv.

**Os arquivos que iremos utilizar são 2:**

1) **DADO/MICRODADOS_ENEM_2022.csv**
   - Esse é o arquivo principal (e o maior de todos), nele termos todas as informações necessárias, assim como os IDs das categorias, que usaremos para criar os relacionamentos.
2) **INPUTS/INPUT_R_MICRODADOS_ENEM_2022.R**
   - Contem os nomes das categorias, como faixa etária, faixa salarial, escolaridade, etc.

### 2. Limpeza dos dados 

Essa é a parte mais demorada dado o tamanho da base. Aqui escolhi fazer um teste em 3 plataformas visando apenas estudos:
1) **Databricks**: [Upando e limpando os dados com Databricks e ProtonSQL](https://github.com/b7s/EstudandoDados/blob/main/Enem/Databricks/)
2) **Airbyte**: [Criando uma automação para salvar a base em um banco realcional usando Airbyte](https://github.com/b7s/EstudandoDados/blob/main/Enem/airbite/)
3) **Laravel**: [Criando uma automação em linha de comando com Laravel e subindo os dados para um banco relacional](https://github.com/b7s/EstudandoDados/blob/main/Enem/laravel/)

### 3. Análise de Desempenho

Toda análise é realizada no Power BI para ganhar tempo e ter maior praticidade na criação dos visuais, além disso, possibilitando filtros avançados e combinações complexas de filtros para o usuário final, caso ele ache necessário, abrindo um leque gigante de possibilidades de análises, saíndo das análises básicas e demoradas feitas apenas via código.

**[Confira a análise no Power BI](https://github.com/b7s/EstudandoDados/blob/main/Enem/PowerBI/)**
