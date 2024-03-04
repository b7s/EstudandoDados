Um breve resumo sobre montar um data lake.

Temos 5 passos para organizar o nosso datalake em uma empresa.


### 1. Levantamento de requisitos

Identificar quais as áreas e quais os dados serão levados para o datalake. O ideal é realizar uma reunião com os gestores das áreas, para entender quais os dados serão enviados e em qual ordem de priorização.

- Quais dados os times precisam
- Entender a volumetria dos dados
- Qual a frequência de atualização
- De onde vem os dados
  - CSV?
  - MYSQL
  - API ...

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/piramide-decisao-dados.png" alt="">
</p>

### 2. Onde armazenar

- Estudar as ferramentas disponíveis, como:
   - Azure
   - AWS
   - ON Primense
- Ver qual o custo por Gigabyte (GB) e saber o custo diário e mensal (depois de entender a volumetria)

### 3. Formato de arquivo

Quando vamos para o lake, deixamos de usar banco de dados relacional e passamos a usar arquivos de armazenamentos diferentes, mais otimizados para uma larga quantidade de dados, como **Delta Lake**, **Parquet**, **Apache Orc**.

Dependendo do tipo de arquivo, já devemos saber qual a **Engine de processamento** que será usada. Por exemplo, se for Orc, o **Hive** é o melhor, se for Delta Lake ou Parquet, o **Spark** é mais recomendado, ou um **Dremio**.

### 4. Oranização por Zonas

Precisamos organizar os dados de uma maneira que faça sentido.

<p align="center">
    <img src="https://meusapps.top/estudos/imagens-publicas/zonas-datalake.png" alt="">
</p>

- **inbound** é o dado bruto, no formato texto
  - `Business Areas`, é onde temos as áreas da empresa, como `Financeiro`, `RH`, `Operações`
  - Dentro da área, temos as **fontes de dados**, que pode ser um `MySQL`, `Mongo`, `Excel`
- **Trusted Zone**, já temos os campos formatados com seus schemas corretos. Ela deve conter os dados atualizados, enquantos nas outras guardam os históricos
- Após isso, podemos começar a analisar os dados e enviá-los para dashboards, apis, etc.


----

### Recomendação que precisa de uma validação maior:

Hoje recomendo o uso do **Dremio** como um datalake. Ele permite que a gente não se preocupe em configurar tudo do zero. Com ele é possivel criar clusters e definir o que cada cluster irá fazer, podendo criar clusters na Amazon, Azure, On Premise de forma rápida. Ele trabalha automaticamente com arquivos Parquet, Apache Drill para consultas SQL e outras ferramentas Open Sources, sem a necessidade de pagar licenças caríssimas como Databricks, AWS, etc. E trabalha com SQL, o que facilita muito o prendizado e a procura por analistas.