# SMART RH - Sistema de Gestao de Recursos Humanos

Sistema web desenvolvido em Laravel para gestao de funcionarios e controle de jornada de trabalho.

---

## Como Rodar o Projeto

git clone https://github.com/ValentimG/sistema-rh-smart.git
cd sistema-rh-smart
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
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
- Tailwind CSS (design)
- JavaScript (AJAX para registro de ponto)

---

## Funcionalidades Implementadas

### Autenticacao
- Registro de usuarios com escolha de tipo (Funcionario ou Gestor)
- Login e logout com redirecionamento inteligente por tipo de usuario

### Para Funcionarios
- Registro de ponto eletronico (entrada, saida almoco, volta almoco, saida)
- Validacao de ordem correta dos registros
- Calculo automatico de horas trabalhadas
- Historico dos ultimos 7 dias com grafico de linha
- Banco de horas com saldo acumulado
- Envio de atestados medicos

### Para Gestores
- Dashboard com metricas (total de funcionarios, presentes, ausentes)
- Graficos de presenca e banco de horas por funcionario
- Cadastro completo de funcionarios com dados pessoais e financeiros
- Gestao de atestados (aprovar ou reprovar)
- Exportacao de registros em CSV
- Perfil do funcionario com abas (atestados, historico de cargos, afastamentos)

---

## Regras de Negocio

- Um registro de ponto por funcionario por dia
- Ordem obrigatoria: entrada, saida almoco, volta almoco, saida
- Calculo de horas: (saida - entrada) - (volta almoco - saida almoco)
- Banco de horas: acima de 8h diarias gera saldo positivo, abaixo gera saldo negativo
- Apenas gestores aprovam ou reprovam atestados

---

## Decisoes Tecnicas

| Decisao | Justificativa |
|---|---|
| SQLite | Simplicidade para desenvolvimento e testes |
| Timezone America/Sao_Paulo | Horarios corretos para o Brasil |
| whereDate() em consultas de data | Compatibilidade com SQLite |
| AJAX nos botoes de ponto | Experiencia sem recarregar a pagina |
| Middlewares gestor e funcionario | Separacao clara de permissoes |
| Comentarios em portugues | Facilitar manutencao por equipe brasileira |
| Design com Tailwind CSS | Estilo limpo e responsivo |

---

## Modelagem do Banco de Dados

### Tabela: funcionarios
Armazena dados pessoais e contratuais dos funcionarios.
Vinculada a tabela users (autenticacao) via user_id.

### Tabela: registros_ponto
Armazena os registros diarios de jornada.
Cada funcionario tem no maximo um registro por dia (unique).
Os quatro horarios sao preenchidos progressivamente.

### Tabela: atestados
Armazena atestados medicos enviados pelos funcionarios.
Gestor pode aprovar ou reprovar.

### Tabela: historico_cargos
Registra alteracoes de cargo ao longo do tempo.

### Tabela: historico_afastamentos
Registra afastamentos (ferias, licencas, suspensoes).

---

## Estrutura de Arquivos

app/
  Http/
    Controllers/
      Auth/RegisteredUserController.php
      AtestadoController.php
      FuncionarioController.php
      RegistroPontoController.php
    Middleware/
      EnsureFuncionario.php
      EnsureGestor.php
  Models/
    Atestado.php
    Funcionario.php
    HistoricoAfastamento.php
    HistoricoCargo.php
    RegistroPonto.php
    User.php
database/
  migrations/
  seeders/
    FuncionarioSeeder.php
resources/views/
  atestados/
  auth/
  funcionarios/
  layouts/
  profile/
  registros/
routes/
  web.php

---

Desenvolvido para o desafio tecnico SMART Redes de Computadores.
