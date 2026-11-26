<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_menampilkan_kategori_dan_jumlah_tugas(): void
    {
        $category = Category::create(['name' => 'Kuliah']);
        Task::create(['title' => 'Tugas 1', 'category_id' => $category->id]);

        $this->get('/categories')
            ->assertOk()
            ->assertSee('Daftar Kategori')
            ->assertSee('Kuliah')
            ->assertSee('1 tugas');
    }

    public function test_form_tambah_kategori_dapat_dibuka(): void
    {
        $this->get('/categories/create')
            ->assertOk()
            ->assertSee('Tambah Kategori Baru');
    }

    public function test_kategori_dapat_disimpan(): void
    {
        $this->post('/categories', ['name' => 'Pribadi'])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Kategori berhasil ditambahkan.');

        $this->assertDatabaseHas('categories', ['name' => 'Pribadi']);
    }

    public function test_nama_kategori_wajib_diisi_dan_unik(): void
    {
        Category::create(['name' => 'Praktikum']);

        $this->post('/categories', ['name' => ''])
            ->assertSessionHasErrors('name');

        $this->post('/categories', ['name' => 'Praktikum'])
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    public function test_form_edit_terisi_data_lama(): void
    {
        $category = Category::create(['name' => 'Kuliah']);

        $this->get(route('categories.edit', $category))
            ->assertOk()
            ->assertSee('Edit Kategori')
            ->assertSee('Kuliah');
    }

    public function test_kategori_dapat_diperbarui(): void
    {
        $category = Category::create(['name' => 'Nama Lama']);

        $this->put(route('categories.update', $category), ['name' => 'Nama Baru'])
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Kategori berhasil diperbarui.');

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Nama Baru']);
    }

    public function test_kategori_dapat_dihapus_dan_tugas_menjadi_tanpa_kategori(): void
    {
        $category = Category::create(['name' => 'Sementara']);
        $task = Task::create(['title' => 'Tugas', 'category_id' => $category->id]);

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Kategori berhasil dihapus.');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertNull($task->fresh()->category_id);
    }
}
