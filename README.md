# Desafio Green API

Este projeto consiste em uma API desenvolvida com **Laravel** no backend, focada na gestão de tarefas e subtarefas. A aplicação permite a criação, alteração, e deleção de tarefas e subtarefas, além de alterar seus status. Essa API foi desenvolvida para o desafio técnico da Green Company.

## Tecnologias Utilizadas

- **PHP**: Linguagem de programação utilizada no backend.
- **Laravel**: Framework PHP para desenvolvimento web.
- **MySQL**: Sistema de gerenciamento de banco de dados.
- **Composer**: Gerenciador de dependências para PHP.
- **Vue.js**: Framework JavaScript para construção da interface de usuário (frontend).
- **Node.js e NPM**: Utilizados para gerenciar dependências e executar o servidor de desenvolvimento Vue.js.

## Requisitos

Antes de começar, você precisa ter as seguintes ferramentas instaladas no seu ambiente:

- PHP 7.4 ou superior
- Composer
- MySQL
- Git
- Node.js
- NPM


## Instalação Back-end

1. **Clone o repositório**

   Clone este repositório em sua máquina local:

   ```bash
   git clone https://github.com/seu-usuario/seu-repositorio.git
   ```

2. **Instale as dependências**

   Após clonar o repositório, instale as dependências do backend:
   
    ```bash
    cd .\teste-tecnico-green-main\backend\desafio-green-api\
    composer install
    ```


3. **Criação do arquivo .env**

   O arquivo .env não foi incluído no repositório por questões de segurança. Para criar o seu arquivo .env, copie o arquivo .env.example para .env:

    ```bash
    cp .env.example .env
    ```
 

4. **Configuração do banco de dados**

   Abra o arquivo .env e configure as credenciais do seu banco de dados para o MySQL:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nome_do_banco
   DB_USERNAME=usuario
   DB_PASSWORD=senha
   ```

5. **Rodar as migrações**

   Para criar as tabelas no banco de dados, execute as migrações:

   ```bash
   php artisan migrate
   ```


5. **Iniciar o servidor**

   Agora você pode rodar a aplicação localmente com o comando:

   ```bash
   php artisan serve
   ```

## Instalação Front-end

  
   1. **instale as dependências do front-end**

      ```sh
      cd .\teste-tecnico-green-main\frontend\desafio-green-app\
      npm install
      ```
    
    
  2. **Compile e recarregue para desenvolvimento**

     ```sh
     npm run dev
     ```




