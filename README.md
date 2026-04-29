# Sistema de RH — Laravel

Sistema de gestão de recursos humanos com controle de ponto, cadastro de funcionários, atestados médicos e dashboard analítico.

---

## Como rodar localmente

```bash
# 1. Clonar o repositório
git clone <url-do-repositorio>
cd sistema-rh

# 2. Instalar dependências PHP
composer install

# 3. Instalar dependências Node
npm install

# 4. Configurar o ambiente
cp .env.example .env
php artisan key:generate

# 5. O projeto usa SQLite — nenhuma instalação de banco é necessária
touch database/database.sqlite

# 6. Executar migrations e popular o banco
php artisan migrate
php artisan db:seed --class=FuncionarioSeeder
php artisan db:seed --class=AtestadoSeeder

# 7. Criar link simbólico para uploads
php artisan storage:link

# 8. Compilar assets
npm run build

# 9. Iniciar o servidor
php artisan serve
```

Acesse: **http://127.0.0.1:8000**

### Credenciais de teste

| Tipo        | E-mail                   | Senha    |
|-------------|--------------------------|----------|
| Gestor      | gestor@teste.com         | 12345678 |
| Funcionário | funcionario1@teste.com   | 12345678 |
| Funcionário | funcionario2@teste.com   | 12345678 |
| Funcionário | funcionario3@teste.com   | 12345678 |
| Funcionário | funcionario4@teste.com   | 12345678 |
| Funcionário | funcionario5@teste.com   | 12345678 |

---

## Stack Tecnológica

| Camada        | Tecnologia                         |
|---------------|------------------------------------|
| Backend       | PHP 8.3 + Laravel 13.6             |
| Autenticação  | Laravel Breeze (session-based)     |
| Banco de dados| SQLite (arquivo local)             |
| Frontend      | HTML, CSS Vanilla, JavaScript ES6+ |
| Gráficos      | Chart.js 4 (CDN)                   |
| Uploads       | Laravel Storage (disk `public`)    |
| Assets        | Vite                               |

---

## Arquitetura e Decisões Técnicas

### Modelagem do banco

```
users ──── funcionarios ──── registros_ponto
                │
                ├──── atestados
                ├──── historico_cargos
                └──── historico_afastamentos
```



### Regras de negócio

**Controle de ponto:**
- Cada etapa só pode ser registrada uma vez por dia (entrada → saída almoço → volta almoço → saída)
- A saída é bloqueada se o almoço foi iniciado mas não encerrado
- Horário calculado com `diffInSeconds` (não `diffInMinutes`) para evitar truncamento de minutos parciais

**Atestados:**
- `dias_afastamento = diffInDays(data_fim, data_inicio) + 1` (inclui o dia inicial)
- Apenas atestados `pendente` podem ser removidos
- Upload restrito a PDF, JPG e PNG com limite de 2 MB
- Gestor vê todos; funcionário vê apenas os próprios

**Cálculos financeiros:**
- `valor_hora = salario_base / carga_horaria_mensal`
- `custo_mensal_com_encargos = salario_base × 1,68`
- `13°_proporcional = (salario_base / 12) × meses_trabalhados`

### Middlewares

| Middleware    | Descrição                                                                   |
|---------------|-----------------------------------------------------------------------------|
| `auth`        | Padrão do Laravel; bloqueia acesso sem sessão ativa                         |
| `gestor`      | Verifica `funcionario->tipo === 'gestor'`; retorna 403 se falhar            |
| `funcionario` | Verifica vínculo do usuário com a tabela `funcionarios`                     |

### Timezone

Configurado em `config/app.php`:
```php
'timezone' => 'America/Sao_Paulo',
```
Garante que `now()` e `today()` usem horário de Brasília, evitando divergências nos registros de ponto.

---

## Funcionalidades Implementadas

### Painel do Gestor (`/gestor/dashboard`)
- Cards de métricas: presentes, ausentes, total de horas hoje, média semanal
- Gráfico de barras: banco de horas por funcionário
- Gráfico de rosca: presença vs ausência
- Tabela de registros do dia com status em tempo real
- **Exportação CSV** dos registros do mês corrente (`/gestor/exportar-csv`)

### Gestão de Funcionários (`/funcionarios`)
- Cadastro completo com 5 seções: pessoal, contato, profissional, remuneração, saúde
- Busca client-side por nome e cargo
- Perfil com 3 abas: Atestados, Histórico de Cargos, Afastamentos
- Cálculo automático de valor/hora, 13° proporcional e custo com encargos

### Controle de Ponto (`/ponto`)
- Relógio digital atualizado em tempo real
- 4 ações via AJAX sem recarregar a página
- Gráfico de barras: horas por dia nos últimos 7 dias
- Indicador circular: saldo do banco de horas

### Atestados (`/atestados`)
- Criação com upload de arquivo
- Fluxo de aprovação gestor: pendente → aprovado/reprovado
- Preview de imagem ou link de download para PDF
- Badge de pendentes no perfil do funcionário

---

## Estrutura de Arquivos

```
app/Models/
  Atestado.php · Funcionario.php · HistoricoAfastamento.php
  HistoricoCargo.php · RegistroPonto.php

app/Http/Controllers/
  AtestadoController.php · FuncionarioController.php · RegistroPontoController.php

database/migrations/
  ..._create_funcionarios_table.php
  ..._create_registros_ponto_table.php
  ..._add_campos_financeiros_to_funcionarios_table.php
  ..._expandir_cadastro_funcionarios.php
  ..._create_atestados_table.php
  ..._create_historico_cargos_table.php
  ..._create_historico_afastamentos_table.php

database/seeders/
  FuncionarioSeeder.php · AtestadoSeeder.php

resources/views/
  atestados/   (create · index · show)
  funcionarios/ (create · edit · index · show)
  registros/   (gestor · index)
```

## Licença

MIT
