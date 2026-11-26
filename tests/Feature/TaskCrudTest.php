<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_daftar_menampilkan_tugas(): void
    {
        Task::create(['title' => 'Belajar CRUD']);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee('Daftar Tugas')
            ->assertSee('Belajar CRUD');
    }

    public function test_daftar_kosong_menampilkan_empty_state(): void
    {
        $this->get('/tasks')
            ->assertOk()
            ->assertSee('Belum ada tugas');
    }

    public function test_form_tambah_dapat_dibuka(): void
    {
        $this->get('/tasks/create')
            ->assertOk()
            ->assertSee('Tambah Tugas Baru');
    }

    public function test_tugas_baru_dapat_disimpan(): void
    {
        $response = $this->post('/tasks', ['title' => 'Menyelesaikan laporan']);

        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Tugas berhasil ditambahkan.');

        $this->assertDatabaseHas('tasks', ['title' => 'Menyelesaikan laporan']);
    }

    public function test_judul_wajib_diisi(): void
    {
        $response = $this->post('/tasks', ['title' => '']);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_form_edit_terisi_data_lama(): void
    {
        $task = Task::create(['title' => 'Judul Lama']);

        $this->get(route('tasks.edit', $task))
            ->assertOk()
            ->assertSee('Edit Tugas')
            ->assertSee('Judul Lama');
    }

    public function test_tugas_dapat_diperbarui(): void
    {
        $task = Task::create(['title' => 'Judul Lama']);

        $response = $this->put(route('tasks.update', $task), ['title' => 'Judul Baru']);

        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Tugas berhasil diperbarui.');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Judul Baru']);
    }

    public function test_tugas_dapat_dihapus(): void
    {
        $task = Task::create(['title' => 'Akan dihapus']);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Tugas berhasil dihapus.');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_description_dan_kategori_tersimpan_serta_tampil(): void
    {
        $category = Category::create(['name' => 'Praktikum']);

        $this->post('/tasks', [
            'title' => 'Laporan Praktikum',
            'description' => 'Deadline hari Jumat',
            'category_id' => $category->id,
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Laporan Praktikum',
            'description' => 'Deadline hari Jumat',
            'category_id' => $category->id,
        ]);

        $this->get('/tasks')
            ->assertOk()
            ->assertSee('Deadline hari Jumat')
            ->assertSee('Praktikum');
    }

    public function test_kategori_tidak_valid_ditolak(): void
    {
        $this->post('/tasks', ['title' => 'Tugas', 'category_id' => 999])
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_status_selesai_dapat_ditandai_dan_dibatalkan(): void
    {
        $task = Task::create(['title' => 'Belajar']);

        $this->patch(route('tasks.toggle', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Tugas ditandai selesai.');

        $this->assertTrue($task->fresh()->is_done);
        $this->get('/tasks')->assertSee('<s>Belajar</s>', false);

        $this->patch(route('tasks.toggle', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Tanda selesai dibatalkan.');

        $this->assertFalse($task->fresh()->is_done);
    }
}
