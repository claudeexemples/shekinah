# Shekinah — Sistema de Gestão Eclesiástica 🇦🇴

Sistema de gestão administrativa para igrejas, adaptado à **realidade angolana**.  
Base de dados: **MySQL 8+** (padrão) · Laravel 11 · PHP 8.2+

---

## Contexto Angola
- Moeda: **Kwanza (AOA)**
- Pagamentos: Dinheiro · Transferência Bancária · **Multicaixa / TPA** · Cartão
- Províncias angolanas no cadastro de visitantes e candidatos
- Fuso horário: **Africa/Luanda (UTC+1)**
- Idioma: **Português de Angola (pt_AO)**

---

## Requisitos
| Requisito | Versão mínima |
|-----------|--------------|
| PHP | 8.2+ |
| MySQL | 8.0+ (ou MariaDB 10.6+) |
| Composer | 2.x |
| Extensões PHP | pdo, pdo_mysql, mbstring, xml, curl, zip |

---

## Instalação

### 1. Instalar dependências
```bash
cd shekinah
composer install
```

### 2. Configurar o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Criar a base de dados MySQL
```sql
-- Executar no MySQL / phpMyAdmin / DBeaver
CREATE DATABASE shekinah
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 4. Editar as credenciais no `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shekinah
DB_USERNAME=root
DB_PASSWORD=a_sua_password
```

### 5. Executar migrações e popular com dados de demonstração
```bash
php artisan migrate --seed
```

### 6. Iniciar o servidor
```bash
php artisan serve
# → http://localhost:8000
```

---

## Módulos
| Módulo | Descrição |
|--------|-----------|
| Dashboard | KPIs, gráficos de presença, alertas, financeiro do mês |
| Culto Dominical | Presença (adultos/adol./crianças), visitantes nominais, oferta em Kz |
| EBD | Escola Bíblica Dominical — aula única para toda a igreja |
| Classe Celestial | Culto infantil — contagem de crianças e professores |
| Classe Bíblica Doutrinária | Chamada nominal, perfil de candidato, alertas de frequência <75% |
| Visitantes | Cadastro e acompanhamento pastoral com bairro/província angolana |
| Financeiro | Ofertas (Kz), despesas, fluxo de caixa — Multicaixa/TPA/Transferência |
| Relatórios | Dominical e mensal, exportação PDF (opcional) |

---

## Regras de Negócio
- ✅ Culto/EBD/Celestial: **sem presença nominal** — apenas contagens agregadas
- ✅ Visitantes: **controlo nominal** com bairro e província angolana
- ✅ Classe Doutrinária: **chamada nominal** por aula, % de frequência automático
- ✅ Alerta automático para candidatos com frequência **< 75%**
- ✅ Oferta em **Kwanza (AOA)** por forma de pagamento (inclui Multicaixa/TPA)
- ✅ Relatórios dominical e mensal com exportação PDF opcional

---

## Exportação PDF (opcional)
```bash
composer require barryvdh/laravel-dompdf
```
Após instalar, os botões "Exportar PDF" ficam activos nos relatórios.

---

## Estrutura do Projecto
```
shekinah/
├── app/Http/Controllers/   8 controllers
├── app/Models/             10 models
├── database/
│   ├── migrations/         4 ficheiros de migração
│   └── seeders/            Dados angolanos (nomes, bairros, províncias)
├── resources/views/        18 páginas Blade + layout master
├── routes/web.php
└── .env.example
```

---

## Autor
Cláudio Alfredo

---

## Licença
MIT — Livre para uso, modificação e distribuição.
