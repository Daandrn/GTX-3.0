# GTX-3.0

GTX 3.0 é uma aplicação web dedicada ao meu time, o Ghost Tóxic Team.
As principais funções da aplicação são:

- Cadastro de jogadores
- Manipulação de solicitações
- Listagem de membros
- Listagem de Canal de stream dos membros

-- GTX 3.0 é a versão atualizada do projeto GTX --

foram utilizadas as seguintes tecnologias:
- PHP 8.3
- Postgres 16
- HTML
- CSS e
- JavaScript
  
O app foi otimizado para o Firefox.

----------------------------------------------------------------------
----------------------INSTRUÇÕES PARA INSTALAÇÃO----------------------

- A criação do banco e tabelas devem ser feitas a partir dos arquivos 'instalaBDgtx3.sql'

- A conexão ao banco de dados deve ser feita nos arquivos 'Connection.php'.

- Requer as seguintes configurações do php para correto funcionamento:

;extension=pgsql
;date.timezone = America/Sao_Paulo
;session.gc_probability = 1
;session.gc_divisor = 100
;session.gc_maxlifetime = 300
