from docx import Document
from copy import deepcopy

path = r'C:\Laragon\www\e-commerce\LAPRAK WEB.docx'
doc = Document(path)

def find_idx(text):
    for i,p in enumerate(doc.paragraphs):
        if p.text.strip() == text:
            return i
    return None

def insert_after(idx, text=None, style=None):
    p = doc.paragraphs[idx]._element
    new_p = deepcopy(doc.paragraphs[idx]._element)
    p.addnext(new_p)
    # refresh
    para = doc.paragraphs[idx+1]
    if text is not None:
        para.text = text
    if style is not None:
        try:
            para.style = style
        except Exception:
            pass
    return idx+1

# 1. cover: add "MATA KULIAH: PEMOGRAMAN WEB (U3)" before DISUSUN OLEH
idx = find_idx('DISUSUN OLEH:')
if idx is not None:
    # insert in order after idx-? easier: build by inserting after idx-1
    # current idx is DISUSUN OLEH. want: dosen line, empty, DISUSUN OLEH
    # so insert before DISUSUN OLEH by inserting after idx-1
    i = idx-1
    i = insert_after(i, 'MATA KULIAH: PEMOGRAMAN WEB (U3)', 'Normal')
    i = insert_after(i, '', 'Normal')
    i = insert_after(i, 'Dosen Pengampu: Masrura Mailany, S.T., M.T.I.', 'Normal')
    i = insert_after(i, '', 'Normal')

# 2. TUJUAN PRAKTIKUM (after heading)
idx = find_idx('TUJUAN PRAKTIKUM')
if idx is not None:
    tujuan = [
        'Mahasiswa mampu menyiapkan lingkungan Laragon dan project Laravel.',
        'Mahasiswa mampu mengonfigurasi koneksi database MySQL pada file .env dan menjalankan migrasi (php artisan migrate).',
        'Mahasiswa mampu membuat routes dengan middleware guest dan auth pada routes/web.php.',
        'Mahasiswa mampu membuat AuthController untuk proses register, login, dan logout (validasi, hash password, session, dan CSRF).',
        'Mahasiswa mampu membuat tampilan Blade (layout, partials, pages, auth) dan menguji alur autentikasi.',
    ]
    i = idx + 1
    # replace empty paragraph after heading if exists
    if i < len(doc.paragraphs) and doc.paragraphs[i].text.strip() == '':
        doc.paragraphs[i].text = tujuan[0]
        try: doc.paragraphs[i].style = 'List Number'
        except: pass
        for t in tujuan[1:]:
            i = insert_after(i, t, 'List Number')
    else:
        for t in reversed(tujuan):
            insert_after(idx, t, 'List Number')

# 3. DASAR TEORI
idx = find_idx('DASAR TEORI')
if idx is not None:
    teori = [
        'Laravel adalah framework PHP berbasis MVC (Model-View-Controller) yang memisahkan logika, data, dan tampilan.',
        'Autentikasi adalah proses verifikasi identitas pengguna (register, login, logout) yang didukung middleware, session, dan proteksi CSRF.',
        'MySQL digunakan sebagai basis data untuk menyimpan data pengguna; konfigurasi koneksi diatur melalui file .env dan struktur tabel dibentuk dengan migration.',
        'Blade adalah template engine Laravel untuk membuat tampilan (layout, partials, pages) yang dapat menyesuaikan status login pengguna.',
    ]
    i = idx + 1
    if i < len(doc.paragraphs) and doc.paragraphs[i].text.strip() == '':
        doc.paragraphs[i].text = teori[0]
        for t in teori[1:]:
            i = insert_after(i, t, 'Normal')
    else:
        for t in reversed(teori):
            insert_after(idx, t, 'Normal')

# 4. LANGKAH KERJA - fill missing and append
idx = find_idx('LANGKAH KERJA')
def add_after_last_in_section(start_marker, next_marker, items, style='List Paragraph'):
    s = find_idx(start_marker)
    e = find_idx(next_marker)
    if s is None or e is None: return
    # find last non-empty before e
    j = e - 1
    while j > s and doc.paragraphs[j].text.strip() == '':
        j -= 1
    # fill P32,P34 if still empty (by index may have shifted; search again)
    for i,p in enumerate(doc.paragraphs):
        if s < i < e and p.text.strip() == '' and p.style.name == 'List Paragraph':
            # leave to be filled by append? easier append all remaining
            pass
    cur = j
    for it in items:
        cur = insert_after(cur, it, style)

# fix specific empty list items by searching their neighbors
# after .env step add description if empty
for i,p in enumerate(doc.paragraphs):
    if 'edit file .env' in p.text:
        # next list paragraph might be empty
        if i+1 < len(doc.paragraphs) and doc.paragraphs[i+1].style.name=='List Paragraph' and doc.paragraphs[i+1].text.strip()=='':
            doc.paragraphs[i+1].text = 'Pastikan DB_CONNECTION=mysql, DB_HOST=127.0.0.1, DB_PORT=3306, DB_DATABASE sesuai (mis. e-commerce), DB_USERNAME=root, DB_PASSWORD kosong (default Laragon).'
    if 'php artisan migrate' in p.text:
        if i+1 < len(doc.paragraphs) and doc.paragraphs[i+1].style.name=='List Paragraph' and doc.paragraphs[i+1].text.strip()=='':
            doc.paragraphs[i+1].text = 'Jika migrasi berhasil, tabel (users, dll) akan terbentuk di database MySQL.'

lanjutan = [
    'Membuat/konfigurasi routes di routes/web.php: route home (/), grup guest untuk GET/POST login & register, POST logout (auth), dan route dashboard (auth). Beri nama route (home, login, register, logout, dashboard).',
    'Membuat AuthController dengan perintah php artisan make:controller AuthController.',
    'Mengisi AuthController: showLogin & showRegister (tampil form), register (validasi, Hash::make password, simpan user, Auth::login, redirect dashboard), login (validasi, Auth::attempt+remember, regenerate session, intended/redirect, error jika gagal), logout (Auth::logout, invalidate session, regenerateToken, redirect home).',
    'Membuat struktur view Blade: layouts/app.blade.php, partials/nav.blade.php, pages/home.blade.php, pages/dashboard.blade.php, auth/login.blade.php, auth/register.blade.php.',
    'Mengisi tiap view: layout (HTML, @include nav, @yield), nav dinamis (@auth/@guest), home & dashboard, form login/register dengan @csrf serta field sesuai (email, password, remember, name, password_confirmation).',
    'Menjalankan aplikasi dengan php artisan serve lalu uji: register akun, login, akses dashboard, uji middleware (guest/auth), dan logout.',
]
add_after_last_in_section('LANGKAH KERJA', 'HASIL DAN PEMBAHASAN PRAKTIKUM', lanjutan)

# 5. HASIL DAN PEMBAHASAN PRAKTIKUM
idx = find_idx('HASIL DAN PEMBAHASAN PRAKTIKUM')
if idx is not None:
    hasil = [
        'Konfigurasi .env ke MySQL dan migrasi berhasil sehingga tabel pengguna terbentuk di database.',
        'Halaman register dapat menyimpan akun baru (password ter-hash) dan langsung mengarahkan ke dashboard.',
        'Halaman login dapat memverifikasi kredensial; jika benar masuk ke dashboard, jika salah menampilkan pesan kesalahan.',
        'Middleware berjalan: dashboard hanya bisa diakses saat login, halaman login/register dibatasi untuk guest, dan logout berhasil mengakhiri sesi.',
        'Tampilan Blade (layout, nav, home, dashboard, auth) tampil sesuai status login pengguna.',
        '[Screenshot: halaman home] [Screenshot: register] [Screenshot: login] [Screenshot: dashboard] [Screenshot: uji akses/middleware/logout]'
    ]
    i = idx + 1
    if i < len(doc.paragraphs) and doc.paragraphs[i].text.strip() == '':
        doc.paragraphs[i].text = hasil[0]
        for t in hasil[1:]:
            i = insert_after(i, t, 'Normal')
    else:
        for t in reversed(hasil):
            insert_after(idx, t, 'Normal')

# 6. KESIMPULAN
idx = find_idx('KESIMPULAN')
if idx is not None:
    kes = 'Berdasarkan praktikum, fitur autentikasi sederhana (register, login, logout) pada Laravel dengan database MySQL berhasil dibuat. Konfigurasi .env, migrasi, routes dengan middleware guest/auth, AuthController (validasi, hash, session, CSRF), serta tampilan Blade berjalan sesuai modul dan dapat diuji dengan baik.'
    i = idx + 1
    if i < len(doc.paragraphs) and doc.paragraphs[i].text.strip() == '':
        doc.paragraphs[i].text = kes
    else:
        insert_after(idx, kes, 'Normal')

# 7. DAFTAR PUSTAKA
idx = find_idx('DAFTAR PUSTAKA')
if idx is not None:
    refs = [
        'Modul 02 - Membuat Auth Sederhana di Laravel, Praktikum Pemrograman Web, UIN Ar-Raniry.',
        'Dokumentasi Laravel: https://laravel.com/docs',
    ]
    i = idx + 1
    if i < len(doc.paragraphs) and doc.paragraphs[i].text.strip() == '':
        doc.paragraphs[i].text = refs[0]
        for t in refs[1:]:
            i = insert_after(i, t, 'Normal')
    else:
        for t in reversed(refs):
            insert_after(idx, t, 'Normal')

doc.save(path)
print('ok')
