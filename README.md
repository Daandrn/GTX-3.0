# GTX-2.0

GTX 2.0 é uma aplicação web dedicada ao meu time, o Ghost Tóxic Team.
As principais funções da aplicação são:

- Cadastro de jogadores
- Manipulação de solicitações
- Listagem de membros
- Listagem de Canal de stream dos membros

-- GTX 2.0 é o meu primeiro projeto --

foram utilizadas as seguintes tecnologias:
- PHP 8.2
- Postgres 16
- HTML
- CSS e
- um pouquinho de JavaScript
  
O app foi otimizado para o Firefox.

----------------------------------------------------------------------
----------------------INSTRUÇÕES PARA INSTALAÇÃO----------------------

- A versão 1.0 está integrada a 2.0, portante é importante a criação de ambos os bancos de dados
A criação do banco e tabelas devem ser feitas a partir dos arquivos 'instalaBDgtx.sql' e 'instalaBDgtx2.sql', disponíveis nas pastas gtx1 e gtx2

- A conexão ao banco de dados deve ser feita nos arquivos 'conexao.php', em ambas as versoes.
 Obs.: cada versao tem seu próprio arquivo conexão.

- Requer as seguintes configurações para correto funcionamento:

;extension=pgsql
;date.timezone = America/Sao_Paulo
;session.gc_probability = 1
;session.gc_divisor = 100
;session.gc_maxlifetime = 300
