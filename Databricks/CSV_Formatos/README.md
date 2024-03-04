Modo simples para ler um arquivo CSV usando **Spark** no **Databricks**

**Lendo de uma URL:**

```pyspark
from pyspark import SparkFiles

spark.sparkContext.addFile("https://algum-site-com-csv.com/teste.csv")

ds1 = spark.read
        .option("header", True)
        .csv("file://" + SparkFiles.get("teste.csv"))

display(ds1)
```

## Formatando os dados

Como forçar o spark a reconhecer as colunas corretamente:

1) Usando StrunctType
    - Em `StructField()`, passamos o nome do campo, depois o tipo desejado e por último se é possivel ter valor vazio
```pyspark

schema = StructType([
    StructField("user_id", IntergerType(), False)
    StructField("username", StringType(), False)
    StructField("comment", StringType(), False)
    StructField("created_at", TimestampType(), False)
])

ds1 = spark.read
        .option("header", True)
        .schema(schema)
        .csv("file://" + SparkFiles.get("teste.csv"))

display(ds1)

```

2) Usando schema string

```pyspark

ds1 = spark.read
        .option("header", True)
        .schema("user_id int, username string, comment string, created_at timestamp")
        .csv("file://" + SparkFiles.get("teste.csv"))

display(ds1)
```

3) Automaticamente 
   - Processo mais lento por ter a necessidade de ler 75% dos dados
   - Use a **option** `inferSchema`
   - Nem sempre ele consegue identificar corretamente

```pyspark

ds1 = spark.read
        .option("header", True)
        .option("inferSchema", True)
        .csv("file://" + SparkFiles.get("teste.csv"))

display(ds1)
```

### Lidando com erros


1) **Um erro comum é o formato da data não estar no padrao esperado**

Quando temos as data e hora não estão na estrutura do Spark, precisamos falar qual o formato correto da data, se não, virão todas como `null`

> O padrão geral para data e hora é "yyyy-MM-dd HH:mm:ss"

```pyspark
ds2 = spark.read
        .option("header", True)
        .option("sep", "|") # caso o separador seja outro, usar a option "sep"
        .option("nullValue", "999999") # Caso precise tranformar algum valor especifico em NULL, podemos usar a option "nullValue" e informar no parametro qual o valor vai ser considerado como null
        .option("timestampFormat", "dd-MM-yyyy HH:mm:ss") # Aqui informamos qual o formato que a data está vindo, para que a coluna seja reconhecida no formato correto
        .schema("user_id int, username string, comment string, created_at timestamp")
        .csv("file://" + SparkFiles.get("teste.csv"))
```

2) **Perder dados**

Por padrão, o Spark coloca como `null` todas os valores que ele não consegue reconhecer/converter

Para mudar isso, temos três modos de leitura:
1) PERMISSIVE (Default): O valor `null` é atribuído aos campos que não foram corretamente parseados
2) DROPMALFORMED: A linha que não for 100% parseada será removida do dataset. Perdemos completamente os dados da linha
3) FAILFAST: Se alguma linha não for 100% parseada, irá lançar uma excessão com o erro de parse

Para alterar o modo, vamos usar a option `mode`:

```pyspark
ds2 = spark.read
        .option("header", True)
        .option("sep", "|") 
        .option("timestampFormat", "dd-MM-yyyy HH:mm:ss")
        .option("mode", "FAILFAST")
        .schema("user_id int, username string, comment string, created_at timestamp")
        .csv("file://" + SparkFiles.get("teste.csv"))
```
