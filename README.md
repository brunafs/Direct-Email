# Direct-Email (Mala Direta)

Sistema, criado para o TCDF (Tribunal de Contas do DF), de envio de documentos/boletins.

É uma aplicação que realiza o cadastro de pessoas interessadas em receber os Boletins da Jurisprudência, como também o cadastro desses boletins (documentos).

Ao realizar o cadastro de um documento, o mesmo é encaminhado via e-mail para todos os cadastrados no assunto do documento/boletim em questão.

Ferramentas usadas:
- PHP - v7.4.6
- PHPMailer - v6.4
- Composer - v1.10.10
- MariaDB - v10.4.11
- Bootstrap - v4.6.0
- Jquery - v3.5.1

Para funcionamento adequado, deve-se ficar atento:
- Email e senha no arquivo email.php
- Banco de dados no arquivo conexao.php
- Caminho do arquivo a ser salvo no servidor nos arquivos de verificação.
