<!DOCTYPE html>
<html lang="pt-AO">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — Shekinah</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* =========================================================
   SHEKINAH — DESIGN SYSTEM
   Contexto: Angola | Moeda: AOA (Kwanza)
   ========================================================= */
:root {
  --color-primary-50:#eef2ff;--color-primary-100:#e0e7ff;--color-primary-200:#c7d2fe;
  --color-primary-300:#a5b4fc;--color-primary-400:#818cf8;--color-primary-500:#6366f1;
  --color-primary-600:#4f46e5;--color-primary-700:#4338ca;--color-primary-800:#3730a3;
  --color-primary-900:#312e81;
  --color-secondary-100:#f3e8ff;--color-secondary-300:#d8b4fe;
  --color-secondary-500:#a855f7;--color-secondary-700:#7e22ce;
  --color-accent-100:#fef3c7;--color-accent-300:#fcd34d;
  --color-accent-500:#f59e0b;--color-accent-600:#d97706;--color-accent-700:#b45309;
  --color-success-50:#f0fdf4;--color-success-100:#dcfce7;
  --color-success-500:#22c55e;--color-success-600:#16a34a;--color-success-700:#15803d;
  --color-warning-50:#fffbeb;--color-warning-100:#fef3c7;--color-warning-500:#f59e0b;
  --color-danger-50:#fff1f2;--color-danger-100:#ffe4e6;
  --color-danger-500:#f43f5e;--color-danger-600:#e11d48;--color-danger-700:#be123c;
  --color-neutral-0:#ffffff;--color-neutral-50:#f8f9fc;--color-neutral-100:#f1f3f8;
  --color-neutral-200:#e4e8f0;--color-neutral-300:#cdd2de;--color-neutral-400:#9ba5b8;
  --color-neutral-500:#6b7591;--color-neutral-600:#4a5268;--color-neutral-700:#333a52;
  --color-neutral-800:#1e2335;--color-neutral-900:#111627;
  --font-display:'Lora',Georgia,serif;
  --font-body:'DM Sans',system-ui,sans-serif;
  --font-mono:'DM Mono',monospace;
  --text-xs:.75rem;--text-sm:.875rem;--text-base:1rem;--text-lg:1.125rem;
  --text-xl:1.25rem;--text-2xl:1.5rem;--text-3xl:1.875rem;
  --space-1:.25rem;--space-2:.5rem;--space-3:.75rem;--space-4:1rem;
  --space-5:1.25rem;--space-6:1.5rem;--space-8:2rem;--space-10:2.5rem;--space-12:3rem;
  --radius-sm:4px;--radius-md:8px;--radius-lg:12px;--radius-xl:16px;--radius-2xl:20px;--radius-full:9999px;
  --shadow-xs:0 1px 2px rgba(17,22,39,.05);
  --shadow-sm:0 1px 4px rgba(17,22,39,.08),0 1px 2px rgba(17,22,39,.04);
  --shadow-md:0 4px 12px rgba(17,22,39,.08),0 2px 4px rgba(17,22,39,.04);
  --shadow-lg:0 8px 24px rgba(17,22,39,.10),0 2px 8px rgba(17,22,39,.04);
  --shadow-xl:0 16px 40px rgba(17,22,39,.12),0 4px 12px rgba(17,22,39,.06);
  --sidebar-width:256px;--header-height:64px;
  --transition-fast:150ms ease;--transition-base:250ms ease;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--font-body);font-size:var(--text-base);color:var(--color-neutral-800);background:var(--color-neutral-50);line-height:1.5;-webkit-font-smoothing:antialiased}
a{color:inherit;text-decoration:none}
button{font-family:inherit;cursor:pointer;border:none;background:none}
input,select,textarea{font-family:inherit}
ul,ol{list-style:none}

/* ── LAYOUT ── */
.app-wrapper{display:flex;min-height:100vh}
.sidebar{width:var(--sidebar-width);background:var(--color-neutral-900);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;transition:width var(--transition-base);overflow:hidden}
.sidebar__brand{display:flex;align-items:center;gap:var(--space-3);padding:var(--space-5);border-bottom:1px solid rgba(255,255,255,.06);flex-shrink:0;min-height:var(--header-height)}
.sidebar__logo{width:36px;height:36px;background:linear-gradient(135deg,var(--color-primary-500),var(--color-secondary-500));border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sidebar__logo svg{width:20px;height:20px;color:white}
.sidebar__brand-name{font-family:var(--font-display);font-weight:600;font-size:var(--text-lg);color:white;line-height:1.1}
.sidebar__brand-sub{font-size:.65rem;color:var(--color-neutral-400);font-weight:500;letter-spacing:.04em}
.sidebar__nav{flex:1;padding:var(--space-4) 0;overflow-y:auto;scrollbar-width:none}
.sidebar__nav::-webkit-scrollbar{display:none}
.sidebar__section-label{font-size:.62rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--color-neutral-500);padding:var(--space-4) var(--space-5) var(--space-2)}
.nav-item{display:flex;align-items:center;gap:var(--space-3);padding:var(--space-3) var(--space-5);color:var(--color-neutral-400);font-size:var(--text-sm);font-weight:500;cursor:pointer;transition:all var(--transition-fast);position:relative;white-space:nowrap;text-decoration:none}
.nav-item:hover{color:white;background:rgba(255,255,255,.05)}
.nav-item.active{color:white;background:rgba(99,102,241,.2)}
.nav-item.active::before{content:'';position:absolute;left:0;top:6px;bottom:6px;width:3px;background:var(--color-primary-400);border-radius:0 2px 2px 0}
.nav-item__icon{width:20px;height:20px;flex-shrink:0;opacity:.7}
.nav-item.active .nav-item__icon,.nav-item:hover .nav-item__icon{opacity:1}
.nav-badge{margin-left:auto;background:var(--color-primary-600);color:white;font-size:10px;font-weight:600;padding:1px 6px;border-radius:var(--radius-full);min-width:18px;text-align:center}
.sidebar__footer{padding:var(--space-4) var(--space-5);border-top:1px solid rgba(255,255,255,.06)}
.sidebar__user{display:flex;align-items:center;gap:var(--space-3)}
.sidebar__avatar{width:36px;height:36px;border-radius:var(--radius-full);background:linear-gradient(135deg,var(--color-primary-600),var(--color-secondary-500));display:flex;align-items:center;justify-content:center;font-size:var(--text-sm);font-weight:600;color:white;flex-shrink:0}
.sidebar__user-name{font-size:var(--text-sm);font-weight:600;color:white;line-height:1.2}
.sidebar__user-role{font-size:var(--text-xs);color:var(--color-neutral-500)}

/* ── MAIN ── */
.main-content{flex:1;margin-left:var(--sidebar-width);display:flex;flex-direction:column;min-height:100vh}
.header{height:var(--header-height);background:var(--color-neutral-0);border-bottom:1px solid var(--color-neutral-200);display:flex;align-items:center;justify-content:space-between;padding:0 var(--space-8);position:sticky;top:0;z-index:50;gap:var(--space-6)}
.header__page-title{font-family:var(--font-display);font-size:var(--text-xl);font-weight:600;color:var(--color-neutral-800);line-height:1.2}
.header__breadcrumb{display:flex;align-items:center;gap:var(--space-2);font-size:var(--text-xs);color:var(--color-neutral-400);margin-top:2px}
.header__right{display:flex;align-items:center;gap:var(--space-3);flex-shrink:0}
.btn-icon{width:36px;height:36px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:var(--color-neutral-500);border:1px solid var(--color-neutral-200);background:var(--color-neutral-0);transition:all var(--transition-fast);cursor:pointer}
.btn-icon:hover{color:var(--color-neutral-700);border-color:var(--color-neutral-300);background:var(--color-neutral-50)}
.page-body{flex:1;padding:var(--space-8);animation:fadeUp 200ms ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}

/* ── BUTTONS ── */
.btn{display:inline-flex;align-items:center;gap:var(--space-2);padding:0 var(--space-5);border-radius:var(--radius-md);font-size:var(--text-sm);font-weight:600;height:38px;transition:all var(--transition-fast);white-space:nowrap;cursor:pointer;border:none}
.btn svg{width:16px;height:16px;flex-shrink:0}
.btn-primary{background:var(--color-primary-600);color:white}
.btn-primary:hover{background:var(--color-primary-700);box-shadow:var(--shadow-md)}
.btn-secondary{background:var(--color-neutral-0);color:var(--color-neutral-700);border:1px solid var(--color-neutral-200)}
.btn-secondary:hover{border-color:var(--color-neutral-300);background:var(--color-neutral-50)}
.btn-ghost{color:var(--color-neutral-600);background:transparent}
.btn-ghost:hover{background:var(--color-neutral-100);color:var(--color-neutral-800)}
.btn-danger{background:var(--color-danger-500);color:white}
.btn-danger:hover{background:var(--color-danger-700)}
.btn-success{background:var(--color-success-500);color:white}
.btn-success:hover{background:var(--color-success-700)}
.btn-sm{height:30px;padding:0 var(--space-3);font-size:var(--text-xs)}
.btn-lg{height:46px;padding:0 var(--space-8);font-size:var(--text-base)}

/* ── CARDS ── */
.card{background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);overflow:hidden}
.card-header{padding:var(--space-5) var(--space-6);border-bottom:1px solid var(--color-neutral-100);display:flex;align-items:center;justify-content:space-between;gap:var(--space-4)}
.card-title{font-family:var(--font-display);font-size:var(--text-base);font-weight:600;color:var(--color-neutral-800)}
.card-body{padding:var(--space-6)}

/* ── KPI ── */
.kpi-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:var(--space-5);margin-bottom:var(--space-8)}
.kpi-card{background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-5) var(--space-6);position:relative;overflow:hidden;transition:box-shadow var(--transition-fast)}
.kpi-card:hover{box-shadow:var(--shadow-md)}
.kpi-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.kpi-card--primary::before{background:var(--color-primary-500)}
.kpi-card--success::before{background:var(--color-success-500)}
.kpi-card--warning::before{background:var(--color-accent-500)}
.kpi-card--secondary::before{background:var(--color-secondary-500)}
.kpi-card--danger::before{background:var(--color-danger-500)}
.kpi-card__header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:var(--space-3)}
.kpi-card__icon{width:40px;height:40px;border-radius:var(--radius-lg);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.kpi-card__icon svg{width:20px;height:20px}
.kpi-card--primary .kpi-card__icon{background:var(--color-primary-50);color:var(--color-primary-600)}
.kpi-card--success .kpi-card__icon{background:var(--color-success-50);color:var(--color-success-700)}
.kpi-card--warning .kpi-card__icon{background:var(--color-warning-50);color:var(--color-accent-700)}
.kpi-card--secondary .kpi-card__icon{background:var(--color-secondary-100);color:var(--color-secondary-700)}
.kpi-card--danger .kpi-card__icon{background:var(--color-danger-50);color:var(--color-danger-700)}
.kpi-card__value{font-family:var(--font-display);font-size:var(--text-3xl);font-weight:700;color:var(--color-neutral-900);line-height:1}
.kpi-card__label{font-size:var(--text-sm);color:var(--color-neutral-500);font-weight:500;margin-top:var(--space-2)}
.kpi-card__sub{font-size:var(--text-xs);color:var(--color-neutral-400);margin-top:var(--space-1)}

/* ── BADGES ── */
.badge{display:inline-flex;align-items:center;gap:var(--space-1);padding:2px 8px;border-radius:var(--radius-full);font-size:var(--text-xs);font-weight:600;white-space:nowrap}
.badge::before{content:'';width:5px;height:5px;border-radius:var(--radius-full);background:currentColor}
.badge-primary{background:var(--color-primary-100);color:var(--color-primary-700)}
.badge-success{background:var(--color-success-100);color:var(--color-success-700)}
.badge-warning{background:var(--color-warning-100);color:var(--color-accent-700)}
.badge-danger{background:var(--color-danger-100);color:var(--color-danger-700)}
.badge-neutral{background:var(--color-neutral-100);color:var(--color-neutral-600)}
.badge-secondary{background:var(--color-secondary-100);color:var(--color-secondary-700)}

/* ── TABLES ── */
.table-wrapper{overflow-x:auto}
.table{width:100%;border-collapse:separate;border-spacing:0}
.table thead th{padding:var(--space-3) var(--space-4);font-size:var(--text-xs);font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--color-neutral-500);background:var(--color-neutral-50);border-bottom:1px solid var(--color-neutral-200);text-align:left;white-space:nowrap}
.table tbody tr{border-bottom:1px solid var(--color-neutral-100);transition:background var(--transition-fast)}
.table tbody tr:hover{background:var(--color-neutral-50)}
.table tbody tr:last-child{border-bottom:none}
.table tbody td{padding:var(--space-3) var(--space-4);font-size:var(--text-sm);color:var(--color-neutral-700);vertical-align:middle}
.table tbody td strong{color:var(--color-neutral-800);font-weight:600}

/* ── FORMS ── */
.form-group{display:flex;flex-direction:column;gap:var(--space-2)}
.form-label{font-size:var(--text-sm);font-weight:600;color:var(--color-neutral-700)}
.form-label .req{color:var(--color-danger-500);margin-left:2px}
.form-input,.form-select,.form-textarea{width:100%;height:40px;padding:0 var(--space-3);border:1.5px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-800);background:var(--color-neutral-0);transition:all var(--transition-fast);outline:none}
.form-textarea{height:auto;min-height:96px;padding:var(--space-3);resize:vertical}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--color-primary-400);box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.form-hint{font-size:var(--text-xs);color:var(--color-neutral-400)}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:var(--space-5)}
.col-span-2{grid-column:span 2}

/* ── COUNT INPUT BIG ── */
.count-wrap{display:flex;flex-direction:column;align-items:center;gap:var(--space-2)}
.count-big{width:100%;text-align:center;font-family:var(--font-display);font-size:2rem;font-weight:700;height:72px;border:2px solid var(--color-neutral-200);border-radius:var(--radius-xl);color:var(--color-neutral-900);background:var(--color-neutral-50);transition:all var(--transition-fast);outline:none}
.count-big:focus{border-color:var(--color-primary-400);background:var(--color-primary-50);box-shadow:0 0 0 4px rgba(99,102,241,.08);color:var(--color-primary-700)}
.count-big[readonly]{background:var(--color-primary-50);color:var(--color-primary-700);border-color:var(--color-primary-200);cursor:not-allowed}
.count-label{font-size:var(--text-sm);font-weight:600;color:var(--color-neutral-500);text-align:center}

/* ── SECTION BLOCKS ── */
.section-header{display:flex;align-items:flex-start;justify-content:space-between;gap:var(--space-4);margin-bottom:var(--space-6)}
.section-title{font-family:var(--font-display);font-size:var(--text-xl);font-weight:600;color:var(--color-neutral-800)}
.section-subtitle{font-size:var(--text-sm);color:var(--color-neutral-500);margin-top:var(--space-1)}
.section-actions{display:flex;align-items:center;gap:var(--space-3);flex-shrink:0}
.section-block{background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);margin-bottom:var(--space-6)}
.section-block-title{font-family:var(--font-display);font-size:var(--text-base);font-weight:600;color:var(--color-neutral-800);margin-bottom:var(--space-5);padding-bottom:var(--space-4);border-bottom:1px solid var(--color-neutral-100);display:flex;align-items:center;gap:var(--space-2)}
.section-block-title svg{width:18px;height:18px;color:var(--color-primary-500)}

/* ── ALERTS ── */
.alert{display:flex;align-items:flex-start;gap:var(--space-3);padding:var(--space-4) var(--space-5);border-radius:var(--radius-lg);font-size:var(--text-sm);border:1px solid transparent;margin-bottom:var(--space-5)}
.alert svg{width:18px;height:18px;flex-shrink:0;margin-top:1px}
.alert-success{background:var(--color-success-50);border-color:var(--color-success-100);color:var(--color-success-700)}
.alert-warning{background:var(--color-warning-50);border-color:var(--color-warning-100);color:var(--color-accent-700)}
.alert-danger{background:var(--color-danger-50);border-color:var(--color-danger-100);color:var(--color-danger-700)}
.alert-info{background:var(--color-primary-50);border-color:var(--color-primary-100);color:var(--color-primary-700)}

/* ── PROGRESS ── */
.progress-bar{width:100%;height:6px;background:var(--color-neutral-100);border-radius:var(--radius-full);overflow:hidden}
.progress-fill{height:100%;border-radius:var(--radius-full);transition:width .4s ease}
.pf-primary{background:var(--color-primary-500)}
.pf-success{background:var(--color-success-500)}
.pf-warning{background:var(--color-accent-500)}
.pf-danger{background:var(--color-danger-500)}

/* ── GRID HELPERS ── */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6)}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:var(--space-5)}
.grid-4{display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:var(--space-5)}
.stack{display:flex;flex-direction:column;gap:var(--space-5)}
.divider{height:1px;background:var(--color-neutral-100);margin:var(--space-6) 0}

/* ── SUMMARY ROW ── */
.summary-row{display:flex;align-items:center;justify-content:space-between;padding:var(--space-3) 0;border-bottom:1px solid var(--color-neutral-100);font-size:var(--text-sm)}
.summary-row:last-child{border-bottom:none}
.sr-label{color:var(--color-neutral-500)}
.sr-value{font-weight:600;color:var(--color-neutral-800)}

/* ── VISITOR ROWS ── */
.visitor-row{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:var(--space-3);align-items:end;padding:var(--space-4);background:var(--color-neutral-50);border:1px solid var(--color-neutral-200);border-radius:var(--radius-lg);margin-bottom:var(--space-3)}
.visitor-remove{width:32px;height:32px;border-radius:var(--radius-md);color:var(--color-danger-500);display:flex;align-items:center;justify-content:center;transition:background var(--transition-fast);cursor:pointer}
.visitor-remove:hover{background:var(--color-danger-50)}

/* ── CANDIDATE ROW ── */
.candidate-row{display:grid;grid-template-columns:28px 1fr 1fr auto;gap:var(--space-4);align-items:center;padding:var(--space-3) var(--space-4);border-radius:var(--radius-lg);border:1px solid var(--color-neutral-200);background:var(--color-neutral-0);transition:all var(--transition-fast)}
.candidate-row:hover{background:var(--color-neutral-50)}
.candidate-row.absent{opacity:.55}
.candidate-row.is-new{border-left:3px solid var(--color-accent-500)}
.cand-check{width:22px;height:22px;border:2px solid var(--color-neutral-300);border-radius:var(--radius-sm);appearance:none;cursor:pointer;transition:all var(--transition-fast);position:relative;flex-shrink:0}
.cand-check:checked{background:var(--color-primary-600);border-color:var(--color-primary-600)}
.cand-check:checked::after{content:'';position:absolute;inset:3px;background:url("data:image/svg+xml,%3Csvg viewBox='0 0 10 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 4L3.5 6.5L9 1' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") center/contain no-repeat}

/* ── ATTENDANCE TIMELINE ── */
.att-timeline{display:flex;flex-wrap:wrap;gap:4px}
.att-dot{width:22px;height:22px;border-radius:4px;cursor:pointer;transition:transform var(--transition-fast)}
.att-dot:hover{transform:scale(1.2)}
.att-dot--present{background:var(--color-success-400)}
.att-dot--absent{background:var(--color-danger-200)}
.att-dot--future{background:var(--color-neutral-200)}

/* ── FLOW CARDS ── */
.flow-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--space-5);margin-bottom:var(--space-8)}
.flow-card{background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);padding:var(--space-6);display:flex;align-items:center;gap:var(--space-4)}
.flow-icon{width:48px;height:48px;border-radius:var(--radius-xl);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.flow-icon svg{width:24px;height:24px}
.flow-card--in .flow-icon{background:var(--color-success-50);color:var(--color-success-600)}
.flow-card--out .flow-icon{background:var(--color-danger-50);color:var(--color-danger-600)}
.flow-card--balance .flow-icon{background:var(--color-primary-50);color:var(--color-primary-600)}
.flow-value{font-family:var(--font-display);font-size:var(--text-2xl);font-weight:700;color:var(--color-neutral-900);line-height:1.2;font-variant-numeric:tabular-nums}
.flow-card--in .flow-value{color:var(--color-success-700)}
.flow-card--out .flow-value{color:var(--color-danger-700)}
.flow-label{font-size:var(--text-sm);color:var(--color-neutral-500);font-weight:500}

/* ── QUICK ACTIONS ── */
.quick-actions{display:flex;gap:var(--space-3);flex-wrap:wrap;margin-bottom:var(--space-6)}
.qa-btn{display:flex;align-items:center;gap:var(--space-2);padding:var(--space-3) var(--space-4);background:var(--color-neutral-0);border:1px solid var(--color-neutral-200);border-radius:var(--radius-xl);font-size:var(--text-sm);font-weight:500;color:var(--color-neutral-700);cursor:pointer;transition:all var(--transition-fast);box-shadow:var(--shadow-xs);text-decoration:none}
.qa-btn:hover{border-color:var(--color-primary-300);color:var(--color-primary-700);background:var(--color-primary-50);box-shadow:var(--shadow-sm)}
.qa-btn svg{width:16px;height:16px}

/* ── MODAL ── */
.modal-overlay{position:fixed;inset:0;background:rgba(17,22,39,.5);backdrop-filter:blur(4px);z-index:200;display:flex;align-items:center;justify-content:center;padding:var(--space-4);opacity:0;visibility:hidden;transition:all var(--transition-base)}
.modal-overlay.open{opacity:1;visibility:visible}
.modal{background:var(--color-neutral-0);border-radius:var(--radius-2xl);box-shadow:var(--shadow-xl);width:100%;max-width:560px;transform:scale(.96) translateY(10px);transition:transform var(--transition-base)}
.modal-overlay.open .modal{transform:scale(1) translateY(0)}
.modal-header{display:flex;align-items:center;justify-content:space-between;padding:var(--space-6);border-bottom:1px solid var(--color-neutral-100)}
.modal-title{font-family:var(--font-display);font-size:var(--text-lg);font-weight:600;color:var(--color-neutral-800)}
.modal-close{width:32px;height:32px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:var(--color-neutral-400);transition:all var(--transition-fast);cursor:pointer}
.modal-close:hover{background:var(--color-neutral-100);color:var(--color-neutral-700)}
.modal-body{padding:var(--space-6)}
.modal-footer{padding:var(--space-4) var(--space-6);border-top:1px solid var(--color-neutral-100);display:flex;justify-content:flex-end;gap:var(--space-3)}

/* ── TOAST ── */
.toast-wrap{position:fixed;bottom:var(--space-6);right:var(--space-6);z-index:300;display:flex;flex-direction:column;gap:var(--space-3);pointer-events:none}
.toast{display:flex;align-items:center;gap:var(--space-3);padding:var(--space-4) var(--space-5);background:var(--color-neutral-900);color:white;border-radius:var(--radius-xl);box-shadow:var(--shadow-xl);font-size:var(--text-sm);font-weight:500;transform:translateX(120%);transition:transform var(--transition-base);pointer-events:auto;max-width:320px}
.toast.show{transform:translateX(0)}

/* ── BAR CHART (CSS) ── */
.bar-chart{display:flex;align-items:flex-end;gap:var(--space-2);height:140px;padding:var(--space-2) 0}
.bar-group{flex:1;display:flex;flex-direction:column;align-items:center;gap:var(--space-2);height:100%;justify-content:flex-end}
.bar{width:100%;border-radius:4px 4px 0 0;min-height:4px;transition:opacity var(--transition-fast)}
.bar:hover{opacity:.8}
.bar--primary{background:var(--color-primary-500)}
.bar--accent{background:var(--color-accent-400)}
.bar-label{font-size:10px;color:var(--color-neutral-400);font-weight:500;text-align:center}

/* ── SEARCH BAR ── */
.search-bar{position:relative;display:flex;align-items:center}
.search-bar svg{position:absolute;left:var(--space-3);width:15px;height:15px;color:var(--color-neutral-400);pointer-events:none}
.search-bar input{height:36px;padding:0 var(--space-3) 0 calc(var(--space-3) + 20px);border:1.5px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-800);background:var(--color-neutral-0);outline:none;transition:all var(--transition-fast);width:220px}
.search-bar input:focus{border-color:var(--color-primary-400);box-shadow:0 0 0 3px rgba(99,102,241,.1)}

/* ── EMPTY STATE ── */
.empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:var(--space-12) var(--space-8);text-align:center;gap:var(--space-4)}
.empty-state__icon{width:56px;height:56px;border-radius:var(--radius-2xl);background:var(--color-neutral-100);display:flex;align-items:center;justify-content:center;color:var(--color-neutral-400)}
.empty-state__title{font-family:var(--font-display);font-size:var(--text-lg);font-weight:600;color:var(--color-neutral-700)}
.empty-state__desc{font-size:var(--text-sm);color:var(--color-neutral-400);max-width:300px}

/* ── RESPONSIVE ── */
@media(max-width:1024px){
  :root{--sidebar-width:72px}
  .sidebar__brand-text,.nav-item span:not(.nav-item__icon),.sidebar__user-info,.sidebar__section-label,.nav-badge{display:none}
  .nav-item{justify-content:center;padding:var(--space-3)}
  .sidebar__brand{justify-content:center}
  .grid-4{grid-template-columns:1fr 1fr}
  .grid-3{grid-template-columns:1fr 1fr}
  .kpi-grid{grid-template-columns:1fr 1fr}
  .flow-grid{grid-template-columns:1fr}
}
@media(max-width:768px){
  :root{--sidebar-width:0px}
  .sidebar{transform:translateX(-100%);width:256px;box-shadow:var(--shadow-xl)}
  .sidebar.open{transform:translateX(0)}
  .sidebar.open .sidebar__brand-text,.sidebar.open .nav-item span,.sidebar.open .sidebar__user-info,.sidebar.open .sidebar__section-label,.sidebar.open .nav-badge{display:flex}
  .main-content{margin-left:0}
  .page-body{padding:var(--space-4)}
  .grid-2,.grid-3,.grid-4,.kpi-grid{grid-template-columns:1fr}
  .form-grid{grid-template-columns:1fr}
  .col-span-2{grid-column:span 1}
  .section-header{flex-direction:column}
  .header{padding:0 var(--space-4)}
  .visitor-row{grid-template-columns:1fr 1fr}
  .candidate-row{grid-template-columns:28px 1fr auto}
}
@media print{
  .sidebar,.header,.quick-actions,.btn,.section-actions,.no-print{display:none!important}
  .main-content{margin-left:0}
  .page-body{padding:0}
  .print-header{display:block!important}
  .card,.section-block{box-shadow:none;break-inside:avoid}
}
.print-header{display:none}
</style>
</head>
<body>
<div class="app-wrapper">

  {{-- SIDEBAR --}}
  <aside class="sidebar" id="sidebar">
    <div class="sidebar__brand">
      <div class="sidebar__logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 2L2 7v10l10 5 10-5V7L12 2z"/>
          <path d="M12 22V12M2 7l10 5M22 7l-10 5"/>
        </svg>
      </div>
      <div>
        <div class="sidebar__brand-name">Shekinah</div>
        <div class="sidebar__brand-sub">Gestão Eclesiástica</div>
      </div>
    </div>

    <nav class="sidebar__nav">
      <div class="sidebar__section-label">Principal</div>
      <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        <span>Dashboard</span>
      </a>

      <div class="sidebar__section-label">Cultos & Aulas</div>
      <a href="{{ route('cultos.index') }}" class="nav-item {{ request()->routeIs('cultos.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        <span>Culto Dominical</span>
      </a>
      <a href="{{ route('ebd.index') }}" class="nav-item {{ request()->routeIs('ebd.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 016.5 2H20v20H6.5a2.5 2.5 0 010-5H20"/></svg>
        <span>EBD</span>
      </a>
      <a href="{{ route('celestial.index') }}" class="nav-item {{ request()->routeIs('celestial.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <span>Classe Celestial</span>
      </a>
      <a href="{{ route('doutrinaria.index') }}" class="nav-item {{ request()->routeIs('doutrinaria.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        <span>Classe Doutrinária</span>
      </a>

      <div class="sidebar__section-label">Gestão</div>
      <a href="{{ route('visitantes.index') }}" class="nav-item {{ request()->routeIs('visitantes.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Visitantes</span>
      </a>
      <a href="{{ route('financeiro.index') }}" class="nav-item {{ request()->routeIs('financeiro.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        <span>Financeiro</span>
      </a>
      <a href="{{ route('relatorios.index') }}" class="nav-item {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
        <svg class="nav-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        <span>Relatórios</span>
      </a>
    </nav>

    <div class="sidebar__footer">
      <div class="sidebar__user">
        <div class="sidebar__avatar">PA</div>
        <div class="sidebar__user-info">
          <div class="sidebar__user-name">Pastor António</div>
          <div class="sidebar__user-role">Administrador</div>
        </div>
      </div>
    </div>
  </aside>

  {{-- MAIN --}}
  <main class="main-content">
    <header class="header">
      <div>
        <h1 class="header__page-title">@yield('page-title', 'Dashboard')</h1>
        <nav class="header__breadcrumb">
          <a href="{{ route('dashboard') }}">Início</a>
          <span> › </span>
          <span>@yield('page-title', 'Dashboard')</span>
        </nav>
      </div>
      <div class="header__right">
        <span style="font-size:var(--text-sm);color:var(--color-neutral-500);font-weight:500;padding:var(--space-2) var(--space-3);background:var(--color-neutral-50);border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);">
          {{ now()->locale('pt')->isoFormat('ddd, DD/MM/YYYY') }}
        </span>
        <button class="btn-icon" onclick="toggleSidebar()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
      </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:0 var(--space-8);padding-top:var(--space-4);">
      <div class="alert alert-success" style="margin-bottom:0;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <span>{{ session('success') }}</span>
      </div>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:0 var(--space-8);padding-top:var(--space-4);">
      <div class="alert alert-danger" style="margin-bottom:0;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
      </div>
    </div>
    @endif

    <div class="page-body">
      @yield('content')
    </div>
  </main>
</div>

{{-- Toast container --}}
<div class="toast-wrap" id="toast-wrap"></div>

{{-- Modals slot --}}
@stack('modals')

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
}

// Close sidebar on overlay click (mobile)
document.addEventListener('click', function(e) {
  const sidebar = document.getElementById('sidebar');
  if (window.innerWidth <= 768 && sidebar.classList.contains('open') && !sidebar.contains(e.target)) {
    sidebar.classList.remove('open');
  }
});

function showToast(msg, type = 'success') {
  const wrap = document.getElementById('toast-wrap');
  const icons = {
    success: `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>`,
    error:   `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
  };
  const t = document.createElement('div');
  t.className = 'toast';
  t.innerHTML = (icons[type] || icons.success) + `<span>${msg}</span>`;
  wrap.appendChild(t);
  requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add('show')));
  setTimeout(() => { t.classList.remove('show'); setTimeout(() => t.remove(), 400); }, 3500);
}

// Confirm delete
function confirmDelete(form) {
  if (confirm('Tem a certeza que quer eliminar este registo? Esta acção não pode ser desfeita.')) {
    form.submit();
  }
}

// Modal open/close
function openModal(id) { document.getElementById(id)?.classList.add('open'); }
function closeModal(id) { document.getElementById(id)?.classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});
</script>

@stack('scripts')
</body>
</html>
