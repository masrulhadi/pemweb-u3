<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Berita') - Portal Berita</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050816;
            --bg-deep: #03050f;
            --surface: rgba(17, 25, 40, 0.72);
            --surface-strong: #0f172a;
            --surface-alt: rgba(30, 41, 59, 0.55);
            --border: rgba(148, 163, 184, 0.18);
            --border-strong: rgba(148, 163, 184, 0.28);
            --text: #e5e7eb;
            --heading: #f8fafc;
            --muted: #94a3b8;
            --primary: #3b82f6;
            --primary-2: #06b6d4;
            --primary-hover: #60a5fa;
            --primary-soft: rgba(59, 130, 246, 0.14);
            --danger: #fb7185;
            --danger-hover: #f43f5e;
            --danger-soft: rgba(251, 113, 133, 0.12);
            --success-bg: rgba(16, 185, 129, 0.14);
            --success-border: rgba(16, 185, 129, 0.35);
            --success-text: #6ee7b7;
            --error-bg: rgba(244, 63, 94, 0.12);
            --error-border: rgba(251, 113, 133, 0.35);
            --error-text: #fecdd3;
            --radius: 18px;
            --radius-sm: 12px;
            --shadow: 0 20px 50px rgba(2, 6, 23, 0.45);
            --glow: 0 0 0 1px rgba(59,130,246,.15), 0 20px 60px rgba(37,99,235,.18);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Manrope", system-ui, -apple-system, "Segoe UI", sans-serif;
            background:
                radial-gradient(1200px 600px at 10% -10%, rgba(59,130,246,.22), transparent 60%),
                radial-gradient(900px 500px at 100% 0%, rgba(6,182,212,.18), transparent 55%),
                radial-gradient(700px 400px at 50% 100%, rgba(37,99,235,.12), transparent 60%),
                linear-gradient(180deg, #060b1a 0%, #050816 45%, #040611 100%);
            color: var(--text);
            line-height: 1.65;
            min-height: 100vh;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(148,163,184,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.05) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(circle at center, black 35%, transparent 85%);
            opacity: .18;
            pointer-events: none;
            z-index: -1;
        }
        a { color: #93c5fd; text-decoration: none; transition: color .2s ease, opacity .2s ease; }
        a:hover { color: #bfdbfe; }
        h1, h2, h3, h4 { line-height: 1.1; color: var(--heading); margin: 0 0 .5rem; letter-spacing: -0.02em; }
        h1, .display { font-family: "Oswald", "Manrope", sans-serif; text-transform: uppercase; letter-spacing: .02em; }
        p { margin: 0 0 .85rem; }
        ul { margin: .5rem 0 .75rem; padding-left: 1.25rem; }
        img { max-width: 100%; }

        .container { max-width: 1180px; margin: 0 auto; padding: 0 1.25rem; }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(14px);
            background: rgba(5, 8, 22, 0.65);
            border-bottom: 1px solid rgba(148,163,184,.12);
        }
        .header-inner { padding: .9rem 0; }
        .page-content { padding: 2.5rem 0 4rem; }
        .site-footer {
            border-top: 1px solid rgba(148,163,184,.12);
            color: var(--muted);
            font-size: .92rem;
            padding: 1.5rem 0 2.5rem;
            text-align: center;
        }

        .nav { display: flex; gap: .4rem; align-items: center; flex-wrap: wrap; }
        .brand {
            font-family: "Oswald", "Manrope", sans-serif;
            font-weight: 600;
            font-size: 1.35rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--heading);
            margin-right: .9rem;
            padding: .2rem 0;
        }
        .brand span { color: #60a5fa; }
        .brand:hover { text-decoration: none; color: var(--heading); }
        .nav a.nav-link {
            color: var(--muted);
            font-weight: 600;
            font-size: .95rem;
            padding: .55rem .9rem;
            border-radius: 999px;
        }
        .nav a.nav-link:hover { color: var(--heading); background: rgba(148,163,184,.08); text-decoration: none; }
        .nav a.nav-link.active { color: #dbeafe; background: rgba(59,130,246,.16); box-shadow: inset 0 0 0 1px rgba(59,130,246,.25); }
        .nav .right { margin-left: auto; display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }
        .user-name { color: var(--muted); font-size: .92rem; padding: 0 .3rem; }
        .inline { display: inline; margin: 0; }

        .stack { display: grid; gap: 1.5rem; }
        .row {
            display: grid;
            gap: 1.1rem;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }
        .card {
            background: linear-gradient(180deg, rgba(30,41,59,.55), rgba(15,23,42,.72));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.35rem 1.4rem;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }
        .card:hover { border-color: var(--border-strong); }
        .card h2, .card h3 { margin-top: 0; }
        .muted { color: var(--muted); }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 2.2rem 2rem;
            background:
                radial-gradient(800px 300px at 0% 0%, rgba(59,130,246,.28), transparent 55%),
                radial-gradient(600px 260px at 100% 20%, rgba(6,182,212,.18), transparent 55%),
                linear-gradient(135deg, rgba(15,23,42,.95), rgba(17,24,39,.75));
            border: 1px solid rgba(96,165,250,.2);
            box-shadow: var(--glow);
        }
        .hero::after {
            content: "";
            position: absolute;
            right: -80px; top: -80px;
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(59,130,246,.35), transparent 65%);
            filter: blur(10px);
            pointer-events: none;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #93c5fd;
            background: rgba(59,130,246,.12);
            border: 1px solid rgba(96,165,250,.25);
            padding: .35rem .7rem;
            border-radius: 999px;
            margin-bottom: .9rem;
        }
        .hero h1, .hero h2 {
            font-family: "Oswald", "Manrope", sans-serif;
            font-size: clamp(2rem, 4.2vw, 3.6rem);
            line-height: .98;
            text-transform: uppercase;
            letter-spacing: .02em;
            margin-bottom: .8rem;
            max-width: 900px;
        }
        .hero .lead { font-size: 1.05rem; color: #cbd5e1; max-width: 760px; margin-bottom: 1.2rem; }
        .section-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 1rem; margin-bottom: .2rem; }
        .section-title { font-family: "Oswald", "Manrope", sans-serif; font-size: 1.7rem; text-transform: uppercase; letter-spacing: .03em; margin: 0; }
        .section-sub { color: var(--muted); margin: 0; }

        .stat { position: relative; overflow: hidden; }
        .stat::before { content:""; position:absolute; inset: auto -20px -30px auto; width: 120px; height: 120px; background: radial-gradient(circle, rgba(59,130,246,.22), transparent 70%); }
        .stat-label { color: var(--muted); font-size: .9rem; text-transform: uppercase; letter-spacing: .08em; margin-bottom: .2rem; }
        .stat-value { font-size: 2.4rem; font-weight: 800; color: var(--heading); margin: .1rem 0 .2rem; letter-spacing: -0.03em; }
        .stat-desc { color: var(--muted); font-size: .92rem; margin: 0; }

        .article-card { display: flex; flex-direction: column; height: 100%; padding: 0; overflow: hidden; transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease; }
        .article-card:hover { transform: translateY(-3px); border-color: rgba(96,165,250,.35); box-shadow: 0 24px 60px rgba(2,6,23,.55), 0 0 0 1px rgba(59,130,246,.12); }
        .article-thumb { width: 100%; height: 200px; object-fit: cover; display: block; background: #0b1220; }
        .article-card-body { padding: 1.05rem 1.15rem 1.2rem; display: flex; flex-direction: column; flex: 1; }
        .article-meta { color: var(--muted); font-size: .88rem; margin-bottom: .55rem; }
        .article-excerpt { flex: 1; margin-bottom: .85rem; color: #cbd5e1; }
        .article-link { font-weight: 700; color: #93c5fd; }
        .article-link:hover { color: #dbeafe; }

        .article-list { list-style: none; padding: 0; margin: 0; display: grid; gap: .8rem; }
        .article-item {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 1rem 1.05rem; border: 1px solid var(--border); border-radius: 14px; background: rgba(15,23,42,.45);
        }
        .article-item:hover { border-color: rgba(96,165,250,.3); background: rgba(15,23,42,.65); }
        .article-item-main { min-width: 0; }
        .article-item-title { font-weight: 700; font-size: 1.05rem; display: inline-block; margin-bottom: .15rem; color: var(--heading); }
        .article-item-title:hover { color: #dbeafe; }
        .article-item-meta { color: var(--muted); font-size: .9rem; }
        .article-actions { display: flex; align-items: center; gap: .45rem; flex-wrap: wrap; }

        .article-detail-img { width: 100%; max-height: 420px; object-fit: cover; border-radius: 14px; margin: 1rem 0 1.25rem; border: 1px solid var(--border); }
        .article-body { font-size: 1.05rem; color: #d1d5db; }
        .detail-actions { margin-top: 1.6rem; padding-top: 1rem; border-top: 1px solid var(--border); color: var(--muted); display: flex; gap: .6rem; flex-wrap: wrap; align-items: center; }

        .flash {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-border);
            padding: .8rem 1rem;
            border-radius: 12px;
            margin: .75rem 0 1rem;
        }
        .error {
            background: var(--error-bg);
            color: var(--error-text);
            border: 1px solid var(--error-border);
            padding: .8rem 1rem;
            border-radius: 12px;
            margin: .75rem 0 1rem;
        }
        .error ul { margin: .25rem 0 0; }

        form label { display: block; margin-top: .95rem; margin-bottom: .35rem; font-weight: 600; font-size: .93rem; color: #e2e8f0; }
        input[type=text], input[type=url], input[type=email], input[type=password], textarea {
            width: 100%; padding: .72rem .85rem; border: 1px solid rgba(148,163,184,.22); border-radius: 12px;
            font: inherit; color: var(--text); background: rgba(2,6,23,.45);
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        input::placeholder, textarea::placeholder { color: #64748b; }
        input:focus, textarea:focus { outline: none; border-color: rgba(96,165,250,.55); box-shadow: 0 0 0 3px rgba(59,130,246,.18); background: rgba(2,6,23,.65); }
        textarea { resize: vertical; }
        .form-hint { margin-top: .35rem; font-size: .9rem; }
        .check-row { display: flex; gap: .55rem; align-items: center; margin-top: .95rem; font-weight: 500; color: #cbd5e1; }
        .check-row input { width: auto; margin: 0; accent-color: var(--primary); }
        .form-actions { margin-top: 1.3rem; display: flex; gap: .6rem; align-items: center; flex-wrap: wrap; }

        .btn, button.btn, a.btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .62rem 1.05rem; border-radius: 999px; font: inherit; font-weight: 700; font-size: .93rem;
            border: 1px solid transparent; cursor: pointer; line-height: 1.2; text-decoration: none;
            transition: transform .15s ease, background .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease;
        }
        .btn:hover, button.btn:hover, a.btn:hover { text-decoration: none; transform: translateY(-1px); }
        .btn-primary, button[type=submit].btn-primary, a.btn-primary {
            background: linear-gradient(135deg, #2563eb, #06b6d4); color: #fff; border-color: transparent;
            box-shadow: 0 8px 24px rgba(37,99,235,.28);
        }
        .btn-primary:hover, button[type=submit].btn-primary:hover, a.btn-primary:hover { filter: brightness(1.08); color: #fff; }
        .btn-secondary, a.btn-secondary, button.btn-secondary {
            background: rgba(148,163,184,.08); color: #e5e7eb; border-color: rgba(148,163,184,.22);
        }
        .btn-secondary:hover, a.btn-secondary:hover, button.btn-secondary:hover { background: rgba(148,163,184,.14); color: #fff; border-color: rgba(148,163,184,.35); }
        .btn-danger, button.btn-danger {
            background: rgba(244,63,94,.1); color: #fecdd3; border-color: rgba(251,113,133,.3);
        }
        .btn-danger:hover, button.btn-danger:hover { background: rgba(244,63,94,.18); color: #fff; border-color: rgba(251,113,133,.45); }
        .btn-sm { padding: .38rem .72rem; font-size: .86rem; }
        .btn-ghost { background: transparent; border-color: transparent; color: var(--muted); }
        .btn-ghost:hover { background: rgba(148,163,184,.1); color: var(--heading); }

        .auth-wrap { max-width: 460px; margin: 1.2rem auto 0; }
        .auth-card { padding: 1.8rem 1.8rem 1.6rem; border: 1px solid rgba(96,165,250,.18); box-shadow: var(--glow); }
        .auth-card h2 { font-family: "Oswald", "Manrope", sans-serif; font-size: 2rem; text-transform: uppercase; letter-spacing: .03em; margin-bottom: .2rem; }
        .auth-footer { margin-top: 1.2rem; color: var(--muted); }

        .pagination { display: flex; gap: .4rem; list-style: none; padding: 0; margin: 1.25rem 0 0; flex-wrap: wrap; }
        .pagination .page-item .page-link, .pagination .page-item span {
            display: inline-flex; align-items: center; justify-content: center; min-width: 2.2rem; height: 2.2rem;
            padding: 0 .65rem; border: 1px solid rgba(148,163,184,.22); border-radius: 999px; color: #cbd5e1; background: rgba(15,23,42,.55); font-size: .93rem;
        }
        .pagination .page-item.active .page-link, .pagination .page-item.active span {
            background: linear-gradient(135deg, #2563eb, #06b6d4); border-color: transparent; color: #fff; font-weight: 700; box-shadow: 0 6px 18px rgba(37,99,235,.25);
        }
        .pagination .page-item.disabled .page-link, .pagination .page-item.disabled span { color: #64748b; background: rgba(15,23,42,.35); }
        .pagination .page-link:hover { background: rgba(59,130,246,.15); color: #fff; text-decoration: none; border-color: rgba(96,165,250,.35); }

        .page-header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .page-header h2 { margin: 0; font-family: "Oswald", "Manrope", sans-serif; font-size: 2rem; text-transform: uppercase; letter-spacing: .03em; }
        .empty-state { text-align: center; padding: 2.2rem 1rem; color: var(--muted); }
        .grid-2 { display: grid; gap: 1.1rem; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); }

        @media (max-width: 720px) {
            .nav .right { margin-left: 0; width: 100%; }
            .article-item { flex-direction: column; align-items: flex-start; }
            .hero { padding: 1.6rem 1.25rem; }
            .page-content { padding-top: 1.6rem; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            @include('partials.nav')
        </div>
    </header>
    <main class="container page-content">
        @yield('content')
    </main>
    <footer class="site-footer">
        <div class="container">Portal Berita &middot; Laravel &middot; {{ date('Y') }}</div>
    </footer>
</body>
</html>
