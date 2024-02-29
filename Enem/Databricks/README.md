

Crie um _notebook_ para tratar os dados enviados.

1) Criar a base `silver`
```sparksql
%sql
CREATE DATABASE IF NOT EXISTS enem_silver;
```

2) Criar a tabela de `microdados`
```sparksql
%sql
CREATE TABLE IF NOT EXISTS enem_silver.microdados;
```

3) **Transformar** os dados e inserir na tabela Silver
    - Aqui já é possivel trabalhar com os dados na sua ferramenta (no meu caso, vou trabalhar no Power BI). Podemos também criar as análises em outro notebook para trabalhar com os dados da *Silver* em um banco *Gold*
```sparksql
%sql
INSERT INTO enem_silver.microdados
SELECT
    NU_INSCRICAO AS id_inscricao
     ,NU_ANO as ano

     ,CASE
          WHEN TP_FAIXA_ETARIA = 1 THEN 'Menor de 17 anos'
          WHEN TP_FAIXA_ETARIA = 2 THEN '17 anos'
          WHEN TP_FAIXA_ETARIA = 3 THEN '18 anos'
          WHEN TP_FAIXA_ETARIA = 4 THEN '19 anos'
          WHEN TP_FAIXA_ETARIA = 5 THEN '20 anos'
          WHEN TP_FAIXA_ETARIA = 6 THEN '21 anos'
          WHEN TP_FAIXA_ETARIA = 7 THEN '22 anos'
          WHEN TP_FAIXA_ETARIA = 8 THEN '23 anos'
          WHEN TP_FAIXA_ETARIA = 9 THEN '24 anos'
          WHEN TP_FAIXA_ETARIA = 10 THEN '25 anos'
          WHEN TP_FAIXA_ETARIA = 11 THEN 'Entre 26 e 30 anos'
          WHEN TP_FAIXA_ETARIA = 12 THEN 'Entre 31 e 35 anos'
          WHEN TP_FAIXA_ETARIA = 13 THEN 'Entre 36 e 40 anos'
          WHEN TP_FAIXA_ETARIA = 14 THEN 'Entre 41 e 45 anos'
          WHEN TP_FAIXA_ETARIA = 15 THEN 'Entre 46 e 50 anos'
          WHEN TP_FAIXA_ETARIA = 16 THEN 'Entre 51 e 55 anos'
          WHEN TP_FAIXA_ETARIA = 17 THEN 'Entre 56 e 60 anos'
          WHEN TP_FAIXA_ETARIA = 18 THEN 'Entre 61 e 65 anos'
          WHEN TP_FAIXA_ETARIA = 19 THEN 'Entre 66 e 70 anos'
          WHEN TP_FAIXA_ETARIA = 20 THEN 'Maior de 70 anos'
    END as faixa_etaria

     ,TP_SEXO as sexo

     ,CASE
          WHEN TP_ESTADO_CIVIL = 0 THEN "Não informado"
          WHEN TP_ESTADO_CIVIL = 1 THEN 'Solteiro(a)'
          WHEN TP_ESTADO_CIVIL = 2 THEN 'Casado(a)/Mora com um(a) companheiro(a)'
          WHEN TP_ESTADO_CIVIL = 3 THEN 'Divorciado(a)/Desquitado(a)/Separado(a)'
          WHEN TP_ESTADO_CIVIL = 4 THEN 'Viúvo(a)'
    END as estado_civil

     ,CASE
          WHEN TP_COR_RACA = 0 THEN 'Não declarado'
          WHEN TP_COR_RACA = 1 THEN 'Branca'
          WHEN TP_COR_RACA = 2 THEN 'Preta'
          WHEN TP_COR_RACA = 3 THEN 'Parda'
          WHEN TP_COR_RACA = 4 THEN 'Amarela'
          WHEN TP_COR_RACA = 5 THEN 'Indígena'
          WHEN TP_COR_RACA = 6 THEN 'Não dispõe da informação'
    END as cor_raca

     ,CASE
          WHEN TP_NACIONALIDADE = 0 THEN 'Não informado'
          WHEN TP_NACIONALIDADE = 1 THEN 'Brasileiro(a)'
          WHEN TP_NACIONALIDADE = 2 THEN 'Brasileiro(a) Naturalizado(a)'
          WHEN TP_NACIONALIDADE = 3 THEN 'Estrangeiro(a)'
          WHEN TP_NACIONALIDADE = 4 THEN 'Brasileiro(a) Nato(a), nascido(a) no exterior'
    END as nacionalidade

     ,CASE
          WHEN TP_ST_CONCLUSAO = 1 THEN 'Já concluí o Ensino Médio'
          WHEN TP_ST_CONCLUSAO = 2 THEN 'Estou cursando e concluirei o Ensino Médio em 2022'
          WHEN TP_ST_CONCLUSAO = 3 THEN 'Estou cursando e concluirei o Ensino Médio após 2022'
          WHEN TP_ST_CONCLUSAO = 4 THEN 'Não concluí e não estou cursando o Ensino Médio'
    END as conclusao_ensino

     ,CASE
          WHEN TP_ESCOLA = 1 THEN 'Não respondeu'
          WHEN TP_ESCOLA = 2 THEN 'Pública'
          WHEN TP_ESCOLA = 3 THEN 'Privada'
    END as tipo_escola

     ,SG_UF_ESC as uf
     ,NO_MUNICIPIO_ESC as cidade
     ,CASE
          WHEN TP_LINGUA = 0 THEN 'Inglês'
          WHEN TP_LINGUA = 1 THEN 'Espanhol'
    END as lingua

     ,CASE
          WHEN TP_PRESENCA_CN = 0 THEN 'Faltou à prova'
          WHEN TP_PRESENCA_CN = 1 THEN 'Presente na prova'
          WHEN TP_PRESENCA_CN = 2 THEN 'Eliminado na prova'
    END as presenca_cn
     ,CASE
          WHEN TP_PRESENCA_CH = 0 THEN 'Faltou à prova'
          WHEN TP_PRESENCA_CH = 1 THEN 'Presente na prova'
          WHEN TP_PRESENCA_CH = 2 THEN 'Eliminado na prova'
    END as presenca_ch
     ,CASE
          WHEN TP_PRESENCA_LC = 0 THEN 'Faltou à prova'
          WHEN TP_PRESENCA_LC = 1 THEN 'Presente na prova'
          WHEN TP_PRESENCA_LC = 2 THEN 'Eliminado na prova'
    END as presenca_lc
     ,CASE
          WHEN TP_PRESENCA_MT = 0 THEN 'Faltou à prova'
          WHEN TP_PRESENCA_MT = 1 THEN 'Presente na prova'
          WHEN TP_PRESENCA_MT = 2 THEN 'Eliminado na prova'
    END as presenca_mt

     ,NU_NOTA_CH as nota_ch
     ,NU_NOTA_CN as nota_cn
     ,NU_NOTA_MT as nota_mt
     ,NU_NOTA_REDACAO as nota_redacao
     ,NU_NOTA_COMP1 as nota_comp1
     ,NU_NOTA_COMP2 as nota_comp2
     ,NU_NOTA_COMP3 as nota_comp3
     ,NU_NOTA_COMP4 as nota_comp4
     ,NU_NOTA_COMP5 as nota_comp5

FROM enem_bronze.microdados
```

