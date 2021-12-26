# Livro digital para o serviço de Oficial de Dia
####  Sistema para controle dos serviços de Oficial de Dia 



 ## Alguns recursos

- Cadastro e Alteração serviços
- Gráfico com a quantidade de púnidos em cada Bateria
- Relatórios de serviços, punidos, sobras e resíduos e de Oficiais/Adjuntos na escala de serviço.
- Relatórios de serviços em PDF, com marca d'àgua e local para assinatura do SCmt
- Perfil de Suporte, Oficial de Dia, Adjunto ao Oficial de Dia e consulta.
- Cadastro de novos militares para utilização do sistemas

- O sistema foi desenvolvido visando uma `OM de Artilharia COM 4 BATERIAS (bc, 1ª BO, 2ª BO e 3ª BO)`e há algum tempo isso, caso queira atualizar o código para as subUnidades ficarem dinâmicas é só criar um request que será bem vindo!
## Tecnologias utilizadas

- HTML5
- CSS3
- JavaScript (ECMAScript 2018)
- PHP 7.2+
- MariaDB 10.4.20
- [MPDF](https://mpdf.github.io/) - Utilizado para gerar os relatórios
- jQuery
- Composer


## Configurações
 Você pode alterar algumas variáveis globais e algumas opções do PHP.INI dentro do arquivo > `config.php`

- Lembrando que é necessário ter a tabela com os militares (recomendo utilizar o sistema de Arranchamento(https://github.com/ocle19/Arranchamento)), para buscar os nomes na hora de adicionar uma punição, o nome da tabela encontra-se no arquivo connectionMilitares.php

##### Não esqueça de:
- Habilitar o `extension=gd ` no php.ini.
- Executar `composer install` para instalar o MPDF.

## Licença
MIT

**Software gratúito!**

