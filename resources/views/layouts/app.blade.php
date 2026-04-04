<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager') – KhedmaFlow</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg:        #0e0f14;
            --surface:   #16181f;
            --surface2:  #1e2029;
            --border:    rgba(255,255,255,.07);
            --accent:    #6c63ff;
            --accent-h:  #8b84ff;
            --todo:      #f59e0b;
            --progress:  #3b82f6;
            --done:      #22c55e;
            --danger:    #ef4444;
            --text:      #e8e9ef;
            --muted:     #6b7280;
            --radius:    14px;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            min-height: 100vh;
        }

        /* ── NAV ── */
        .navbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            color: var(--text) !important;
            letter-spacing: -.02em;
        }
        .navbar-brand span { color: var(--accent); }

        /* ── CONTAINER ── */
        .main-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* ── CARDS / SURFACES ── */
        .card-surface {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
        }

        /* ── STATUS BADGES ── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .3rem .75rem;
            border-radius: 100px;
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .02em;
        }
        .status-todo     { background: rgba(245,158,11,.12); color: var(--todo);     border: 1px solid rgba(245,158,11,.25); }
        .status-progress { background: rgba(59,130,246,.12); color: var(--progress); border: 1px solid rgba(59,130,246,.25); }
        .status-done     { background: rgba(34,197,94,.12);  color: var(--done);     border: 1px solid rgba(34,197,94,.25);  }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.1rem 1.3rem;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            display: block;
        }
        .stat-card:hover { border-color: var(--accent); transform: translateY(-2px); }
        .stat-card.active { border-color: var(--accent); background: rgba(108,99,255,.08); }
        .stat-card .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }
        .stat-card .stat-label { font-size: .82rem; color: var(--muted); margin-top: .25rem; }

        /* ── TABLE ── */
        .task-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .task-table thead th {
            background: var(--surface2);
            color: var(--muted);
            font-size: .78rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--border);
        }
        .task-table thead th:first-child { border-radius: var(--radius) 0 0 0; }
        .task-table thead th:last-child  { border-radius: 0 var(--radius) 0 0; }
        .task-table tbody tr {
            transition: background .15s;
        }
        .task-table tbody tr:hover td { background: rgba(255,255,255,.03); }
        .task-table tbody td {
            padding: .9rem 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        .task-table tbody tr:last-child td { border-bottom: none; }
        .task-title { font-weight: 500; color: var(--text); }
        .task-title.done-title { text-decoration: line-through; color: var(--muted); }
        .task-desc { font-size: .82rem; color: var(--muted); margin-top: .15rem; }
        .overdue-badge {
            font-size: .72rem;
            color: var(--danger);
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.2);
            border-radius: 100px;
            padding: .1rem .5rem;
            margin-left: .4rem;
        }

        /* ── BUTTONS ── */
        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem 1.1rem;
            font-weight: 600;
            font-size: .88rem;
            transition: background .2s, transform .15s;
        }
        .btn-accent:hover { background: var(--accent-h); color: #fff; transform: translateY(-1px); }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--muted);
            border-radius: 8px;
            padding: .45rem .9rem;
            font-size: .85rem;
            transition: all .2s;
        }
        .btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

        .btn-icon {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            border-radius: 8px;
            padding: .35rem .65rem;
            font-size: .85rem;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-icon:hover { color: var(--text); border-color: rgba(255,255,255,.2); }
        .btn-icon.btn-done:hover  { color: var(--done);  border-color: var(--done);    background: rgba(34,197,94,.08); }
        .btn-icon.btn-edit:hover  { color: var(--accent); border-color: var(--accent); background: rgba(108,99,255,.08); }
        .btn-icon.btn-del:hover   { color: var(--danger); border-color: var(--danger); background: rgba(239,68,68,.08); }

        /* ── FORMS ── */
        .form-label { font-size: .85rem; font-weight: 500; color: var(--muted); margin-bottom: .4rem; }
        .form-control, .form-select {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 10px;
            padding: .65rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            transition: border-color .2s;
        }
        .form-control:focus, .form-select:focus {
            background: var(--surface2);
            color: var(--text);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108,99,255,.2);
        }
        .form-control::placeholder { color: var(--muted); }
        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger);
        }
        .invalid-feedback { font-size: .82rem; }
        .form-select option { background: var(--surface2); }

        /* ── ALERTS ── */
        .alert-success-custom {
            background: rgba(34,197,94,.1);
            border: 1px solid rgba(34,197,94,.2);
            color: var(--done);
            border-radius: var(--radius);
            padding: .8rem 1.2rem;
            font-size: .88rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .alert-error-custom {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.2);
            color: var(--danger);
            border-radius: var(--radius);
            padding: .8rem 1.2rem;
            font-size: .88rem;
        }

        /* ── PAGE TITLE ── */
        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem;
            font-weight: 800;
            letter-spacing: -.03em;
            margin: 0;
        }

        /* ── SEARCH / FILTER BAR ── */
        .filter-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.2rem;
        }

        /* ── PAGINATION ── */
        .pagination { gap: .25rem; }
        .page-link {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            border-radius: 8px !important;
            font-size: .85rem;
            padding: .4rem .8rem;
        }
        .page-link:hover { background: var(--surface); color: var(--text); border-color: rgba(255,255,255,.2); }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--muted);
        }
        .empty-state i { font-size: 3rem; opacity: .3; display: block; margin-bottom: 1rem; }
        .empty-state p { margin: 0; font-size: .95rem; }

        @media (max-width: 768px) {
            .hide-mobile { display: none !important; }
            .task-table thead th, .task-table tbody td { padding: .65rem .6rem; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('tasks.index') }}">
            <i class="bi bi-check2-square me-2"></i>Task<span>Flow</span>
        </a>
        <a href="{{ route('tasks.create') }}" class="btn-accent" style="text-decoration:none; padding:.5rem 1.2rem; border-radius:8px; font-weight:600; font-size:.88rem;">
            <i class="bi bi-plus-lg me-1"></i> Nouvelle tâche
        </a>
    </div>
</nav>

<div class="main-wrapper">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert-success-custom mb-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error-custom mb-3">
            <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Des erreurs ont été détectées :</strong>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
