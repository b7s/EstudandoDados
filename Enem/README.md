
Este é um projeto abrangente de ciência de dados, englobando todas as fases, desde a coleta até o deploy, focado na limpeza, análise exploratória e modelagem dos microdados do Enem 2022, utilizando dados públicos reais. A estruturação da solução segue o framework CRISP-DM, incluindo a compreensão do problema, análise dos dados, limpeza, modelagem e deploy.

A limpeza dos dados foi essencial, dada a grande dimensão do conjunto original de microdados, ultrapassando 2 GB, o que tornaria a manipulação, análise e modelagem inviáveis.

A análise e modelagem são conduzidas em duas abordagens distintas:

1) **Análise e modelagem de desempenho**: Objetiva identificar as principais variáveis que impactam a nota do candidato, sua relação com o desempenho e como podem ser usadas na predição. Para isso, utiliza-se um modelo de Regressão Lasso.

2) **Análise e modelagem de abstenção**: Tem como foco identificar os fatores que influenciam a ausência do candidato na prova, analisando como esses fatores se relacionam e utilizando um modelo de Regressão Logística para prever a probabilidade de abstenção do estudante.

Essas análises têm potencial aplicação em interesses educacionais, possibilitando ao governo implementar intervenções preventivas, aprimorar a comunicação e desenvolver estratégias para reduzir a alta taxa de abstenção em pontos críticos, melhorando assim a qualidade do exame e da educação no país.

Adicionalmente, a identificação dos fatores que mais impactam a nota do candidato permite ao governo identificar talentos potenciais e necessidades individuais, possibilitando o desenvolvimento de estratégias educacionais mais eficazes.

Para facilitar o uso prático dessas análises, foram desenvolvidas duas APIs Flask para o deploy dos modelos, proporcionando a previsão da nota ou da probabilidade de abstenção com base em dados socioeconômicos e educacionais do candidato.

Cada etapa de análise e modelagem será detalhada nos próximos tópicos.

## 1. Limpeza dos dados 

## 2. Análise de Desempenho

#### Passos no Power
1) Adicionar a tabela principal do `enem` (fato) e a tabela `taxonomies` (dimensão)
2) Criar os relacionamentos das categorias
    - Para isso, vamos adicionar a tabela `Taxonomies` e criar referências dela para cada categoria (confira no arquivo como ficou), servindo como tabelas `Dimensão`. Isso elimina a necessidade de ter várias conexões ativas com o banco, puxando os dados apenas uma vez, é útil quando se pretende ter uma base atualizando várias vezes.
    - Faça os relacionamentos de cada tabela dimensão (taxonomias) com a tabela fato (enem) na sua coluna respectiva
3) Criar uma coluna para identificar a presença 
4) Criar uma medida indicando a nota média geral no exame para os candidatos.

## 3. Análise de Abstenção
