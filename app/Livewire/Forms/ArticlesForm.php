<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Article;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticlesForm extends Form
{
    public string $title = '';
    public string $content = '';
    public $thumbnail;
    public ?int $user_id = null; // PERBAIKAN 1: Deklarasikan properti user_id
    public string $published_at = '';
    public ?Article $article = null;

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('articles', 'title')->ignore($this->article?->id),
            ],
            'content' => [
                'nullable',
                'string',
            ],
            // PERBAIKAN 2: Validasi dinamis (hanya validasi gambar jika ada file baru yang diunggah)
            'thumbnail' => [
                'nullable',
                $this->thumbnail instanceof UploadedFile ? 'image' : 'string',
                $this->thumbnail instanceof UploadedFile ? 'mimes:jpg,jpeg,png,webp' : '',
                $this->thumbnail instanceof UploadedFile ? 'max:2048' : '',
            ],
            'user_id' => [
                'nullable',
                'integer',
            ],
            'published_at' => [
                'required',
                'date',
            ],
        ];
    }

    // Fungsi untuk Simpan Data Baru
    public function store()
    {
        $this->validate();

        $thumbnailPath = null;
        if ($this->thumbnail instanceof UploadedFile) {
            $thumbnailPath = $this->thumbnail->store('articles', 'public');
        }

        Article::create([
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail' => $thumbnailPath,
            'user_id' => $this->user_id ?? auth()->id(), // Gunakan input UI, jika kosong pakai ID login
            'published_at' => $this->published_at,
        ]);

        $this->reset();
    }

    // Fungsi untuk Set Data ke Form saat Edit
    public function setArticle(Article $article): void
    {
        $this->article = $article;
        $this->title = $article->title;
        $this->content = $article->content ?? '';
        $this->thumbnail = $article->thumbnail ?? '';
        $this->user_id = $article->user_id;
        
        // Memastikan format tanggal aman untuk elemen HTML <input type="date">
        $this->published_at = $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('Y-m-d') : '';
    }

    // Fungsi untuk Update Data Lama
    public function update()
    {
        $this->validate();

        // Ambil path gambar lama sebagai default
        $thumbnailPath = $this->article->thumbnail;

        // PERBAIKAN 3: Jika ada gambar baru diunggah, hapus gambar lama dan simpan yang baru
        if ($this->thumbnail instanceof UploadedFile) {
            if ($this->article->thumbnail) {
                Storage::disk('public')->delete($this->article->thumbnail);
            }
            $thumbnailPath = $this->thumbnail->store('articles', 'public');
        }

        $this->article->update([
            'title' => $this->title,
            'content' => $this->content,
            'thumbnail' => $thumbnailPath,
            'user_id' => $this->user_id ?? auth()->id(),
            'published_at' => $this->published_at,
        ]);
    }
}