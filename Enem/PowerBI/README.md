#### Passos no Power
1) Adicionar a tabela principal do `enem` (fato) e a tabela `taxonomies` (dimensão)
2) Criar os relacionamentos das categorias
    - Para isso, vamos adicionar a tabela `Taxonomies` e criar referências dela para cada categoria (confira no arquivo como ficou), servindo como tabelas `Dimensão`. Isso elimina a necessidade de ter várias conexões ativas com o banco, puxando os dados apenas uma vez, é útil quando se pretende ter uma base atualizando várias vezes.
    - Faça os relacionamentos de cada tabela dimensão (taxonomias) com a tabela fato (enem) na sua coluna respectiva
3) Criar uma coluna para identificar a presença 
4) Criar uma medida indicando a nota média geral no exame para os candidatos.

----

O arquivo completo do Power BI (visual + dados) pode ser baixado no link: https://1drv.ms/u/s!Alu3NT3bt007gtkhk1jKtNRmeev-nw?e=3wCnQo
