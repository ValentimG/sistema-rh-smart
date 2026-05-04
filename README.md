# SMART RH - Sistema de Gestao de Recursos Humanos

Sistema web desenvolvido em Laravel para gestao de funcionarios e controle de jornada de trabalho.

---

## Como Rodar o Projeto

### Requisitos

- **PHP** 8.2 ou superior
- **Composer** (gerenciador de dependencias PHP)
- **Node.js** e **NPM** (para compilar assets)
- **Git** (para clonar o repositorio)

### Instalacao por Sistema Operacional

#### Windows
1. Instale o PHP: https://windows.php.net/download
2. Instale o Composer: https://getcomposer.org/Composer-Setup.exe
3. Instale o Node.js: https://nodejs.org (versao LTS)
4. Instale o Git: https://git-scm.com/download/win

#### macOS
brew install php@8.3 composer node git

#### Linux (Ubuntu/Debian)
sudo apt update
sudo apt install php8.3 php8.3-sqlite3 php8.3-mbstring php8.3-xml composer nodejs npm git

### Rodando o projeto (todos os sistemas)

git clone https://github.com/ValentimG/sistema-rh-smart.git
cd sistema-rh-smart
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve

Acesse: http://127.0.0.1:8000

---

## Credenciais de Acesso

### Gestor
| Nome | Email | Senha |
|---|---|---|
| Carlos Mendes | gestor@teste.com | 12345678 |

### Funcionarios
| Nome | Email | Senha | Cargo |
|---|---|---|---|
| Ana Silva | funcionario1@teste.com | 12345678 | Desenvolvedora Backend |
| Bruno Costa | funcionario2@teste.com | 12345678 | Designer UX |
| Debora Souza | funcionario3@teste.com | 12345678 | Analista Financeira |
| Eduardo Lima | funcionario4@teste.com | 12345678 | Analista Financeiro |
| Fernanda Rocha | funcionario5@teste.com | 12345678 | Desenvolvedora Frontend |

---

## Tecnologias Utilizadas

- PHP 8.3 + Laravel 13.6
- SQLite (banco de dados)
- Laravel Breeze (autenticacao)
- Chart.js (graficos)
- FullCalendar (calendario)
- CSS customizado com variaveis e modo escuro
- JavaScript modular (AJAX, mascaras, graficos)

---

## Funcionalidades Implementadas

### Autenticacao
- Registro com escolha de tipo (Funcionario ou Gestor)
- Redirecionamento inteligente por tipo de usuario
- Completar perfil apos primeiro acesso

### Para Funcionarios
- Registro de ponto eletronico com AJAX (4 horarios)
- Validacao de ordem correta dos registros
- Calculo automatico de horas trabalhadas
- Historico dos ultimos 7 dias com grafico
- Banco de horas com extrato detalhado e grafico de evolucao
- Envio de atestados medicos
- Solicitacao de ferias
- Calendario de eventos pessoais

### Para Gestores
- Dashboard com metricas, graficos e exportacao CSV
- CRUD completo de funcionarios com dados financeiros
- Gestao de atestados (aprovar/reprovar)
- Gestao de ferias (aprovar/reprovar)
- Extrato de banco de horas de qualquer funcionario
- Calendario de eventos da empresa e feriados

---

## Regras de Negocio

- Um registro de ponto por funcionario por dia
- Ordem obrigatoria: entrada, saida almoco, volta almoco, saida
- Calculo de horas: (saida - entrada) - (volta almoco - saida almoco)
- Banco de horas: acima de 8h gera saldo positivo, abaixo gera negativo
- Datas de admissao e nascimento nao podem ser futuras
- Idade minima de 14 anos para cadastro
- CPF e telefone com mascara de formatacao

---

## Estrutura do Banco de Dados

### Tabelas principais
- **funcionarios** - dados pessoais, contratuais e financeiros
- **registros_ponto** - registros diarios de jornada
- **atestados** - atestados medicos com status
- **ferias** - solicitacoes de ferias com aprovacao
- **eventos_calendario** - eventos pessoais e da empresa
- **historico_cargos** - alteracoes de cargo
- **historico_afastamentos** - registro de afastamentos
- **ajustes_ponto** - solicitacoes de ajuste de horario

---

## Decisoes Tecnicas

| Decisao | Justificativa |
|---|---|
| SQLite | Simplicidade para desenvolvimento e testes |
| Timezone America/Sao_Paulo | Horarios corretos para o Brasil |
| whereDate() em consultas de data | Compatibilidade com SQLite |
| AJAX nos botoes de ponto | Experiencia sem recarregar a pagina |
| Middlewares gestor e funcionario | Separacao clara de permissoes |
| CSS customizado com variaveis | Design consistente e modo escuro |
| JavaScript modular | Codigo organizado e reutilizavel |

---

## Autor

Lorenzo Valentim Gomes da Silva