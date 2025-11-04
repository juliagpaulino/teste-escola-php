# 🏫 Teste de Programação — Gestão Escolar

Este repositório contém a implementação do **teste de programação para Gestão Escolar**, estruturado com uma **arquitetura de API desacoplada**.

---

## 🧩 Stack Tecnológica

| Camada                 | Tecnologia                                                 | Descrição                                                                                                       |
| ---------------------- | ---------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------- |
| **Backend (API)**      | [Laravel 10](https://laravel.com) — PHP 8.2                | Lida com toda a lógica de negócio e comunicação com o banco de dados.                                           |
| **Frontend (Cliente)** | [Vue.js 3](https://vuejs.org) — [Vite](https://vitejs.dev) | Interface do usuário para consumo da API.                                                                       |
| **Infraestrutura**     | [Lando](https://lando.dev) (Docker)                        | Ambientes isolados e automatizados com 3 serviços: `appserver` (PHP), `database` (MySQL) e `node` (Node.js 20). |

---

## 🚀 Como Rodar o Projeto

### 🧰 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

* [Docker Desktop](https://www.docker.com/products/docker-desktop) (em execução)
* [Lando](https://lando.dev/download/)

---

### 🔹 Passo 1: Iniciar os Containers

Na pasta raiz do projeto (`teste-escola`), execute:

```bash
lando start
```

Isso irá construir os containers definidos no `.lando.yml` (PHP, Node e MySQL).

---

### 🔹 Passo 2: Preparar o Backend (Laravel API)

```bash
# 1. Instalar dependências PHP
lando composer --working-dir=backend install

# 2. Criar arquivo de ambiente
cp backend/.env.example backend/.env
```

**Edite o arquivo `.env`** para ajustar as variáveis de conexão com o banco:

```
DB_CONNECTION=mysql
DB_HOST=database       # (altere de 127.0.0.1 para 'database')
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel    # (substitua 'root' por 'laravel')
DB_PASSWORD=laravel    # (adicione a senha)
```

Em seguida, gere a chave da aplicação e configure o banco:

```bash
# 3. Gerar chave da aplicação
lando artisan --working-dir=backend key:generate

# 4. Migrar e popular o banco
lando artisan --working-dir=backend migrate:fresh --seed --class=TesteSeeder
```

---

### 🔹 Passo 3: Corrigir Permissões

```bash
# Ajustar permissões para o servidor web (www-data)
lando ssh -c "chown -R www-data:www-data /app/backend/storage /app/backend/bootstrap/cache /app/backend/app"
```

---

### 🔹 Passo 4: Preparar o Frontend (Vue.js)

```bash
# Instalar dependências do frontend
lando npm --prefix frontend install
```

---

### 🔹 Passo 5: Rodar o Servidor do Frontend

```bash
# Em um novo terminal
lando npm --prefix frontend run dev -- --host
```

---

### 🔹 Passo 6: Acessar o Sistema

Após iniciar todos os serviços:

* **API Backend:** [http://teste-escola.lndo.site](http://teste-escola.lndo.site)
* **Frontend (Vue):** [http://localhost:5173](http://localhost:5173)

Abra o link do frontend no navegador para utilizar o sistema.

---

## 🧾 Observações

* O ambiente Lando cuida automaticamente das dependências e da comunicação entre containers.
* Caso encontre erros de permissão ou cache, reinicie os containers com `lando restart`.
* As seeds de teste podem ser personalizadas no arquivo `backend/database/seeders/TesteSeeder.php`.

---


