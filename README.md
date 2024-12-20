# Sistema de Gerenciamento de Tarefas

Um sistema robusto para gerenciamento de tarefas desenvolvido com Laravel 11, permitindo organização e compartilhamento de tarefas entre usuários.

## Instalação

1. Clone o repositório
```bash
git clone https://github.com/clevisonbarbosa/laravel-task-management-system.git
cd laravel-task-management-system
```

2. Instale as dependências
```bash
composer install
npm install
```

3. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

4. Compile os assets do frontend em um terminal separado
```bash
npm run dev  # Para ambiente de desenvolvimento
# OU
npm run build # Para ambiente de produção
```

5. Configure o banco de dados (MySQL ou SQLite)
- Para MySQL: configure as credenciais no arquivo `.env`
- Para SQLite: execute os comandos abaixo para configurar:
```bash
touch database/database.sqlite
php artisan migrate
```

6. Inicie o servidor
```bash
php artisan serve
```

## Funcionalidades

### 1. Gerenciamento de Tarefas
- Criação, edição e exclusão de tarefas
- Marcação de tarefas como concluídas
- Atribuição de categorias às tarefas
- Compartilhamento de tarefas com outros usuários
- Visualização apenas das tarefas atribuídas ao usuário

### 2. Sistema de Filtros
- Filtro por categoria
  - Selecione uma categoria no dropdown
  - Clique em "Filtrar" para ver apenas tarefas dessa categoria

- Filtro por status
  - Opções: Todas, Concluídas, Pendentes
  - Filtra tarefas baseado em seu estado de conclusão

### 3. Limpeza Automática
O sistema inclui um job automatizado para limpar tarefas antigas:

- Remove tarefas concluídas após 7 dias
- Pode ser executado manualmente:
```bash
php artisan tasks:delete-old
```

- Para processar a fila de jobs:
```bash
php artisan queue:work
```

## Testes

O projeto inclui testes automatizados cobrindo todas as funcionalidades principais:

```bash
php artisan test
```

Os testes incluem:
- Autenticação de usuários
- CRUD de tarefas
- Filtros de categoria e status
- Relacionamentos entre modelos
- Job de limpeza automática
