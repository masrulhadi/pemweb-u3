<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Berita') - Portal Berita</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 960px;
               margin: 0 auto; padding: 1rem; line-height: 1.5; }
        .nav { display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; }
        .nav .right { margin-left: auto; display: flex; gap: 1rem;
                      align-items: center; }
        .nav a.active { font-weight: 700; text-decoration: underline; }
        .inline { display: inline; }
        .card { border: 1px solid #ddd; border-radius: 10px; padding: 1rem; }
        .row { display: grid; gap: 1rem;
               grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); }
        .muted { color: #666; }
        .flash { background: #e6f4ea; border: 1px solid #b7dfc3;
                 padding: .5rem .75rem; border-radius: 8px; margin: .75rem 0; }
        .error { background: #fdecea; border: 1px solid #f5c2bd;
                 padding: .5rem .75rem; border-radius: 8px; margin: .75rem 0; }
        form label { display: block; margin-top: .75rem; font-weight: 600; }
        input[type=text], input[type=url], input[type=email],
        input[type=password], textarea { width: 100%; padding: .5rem;
                                         box-sizing: border-box; }
        .pagination { display: flex; gap: .25rem; list-style: none; padding: 0; }
        .pagination li.active span { font-weight: 700; }
    </style>
</head>
<body>
    @include('partials.nav')
    <main>
        @yield('content')
    </main>
</body>
</html>
