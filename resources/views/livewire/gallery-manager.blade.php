<div class="gallery-wrapper">

    {{-- ===== HEADER ===== --}}
    <div class="gallery-header">
        <div class="gallery-header__left">
            <h1 class="gallery-header__title">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                </svg>
                Galeri Foto
            </h1>
            <div class="gallery-header__stats">
                <span class="stat-badge">{{ $totalCount }} foto</span>
                <span class="stat-badge stat-badge--featured">{{ $featuredCount }} unggulan</span>
            </div>
        </div>
        <button wire:click="openCreateModal" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Foto
        </button>
    </div>

    {{-- ===== FLASH MESSAGE ===== --}}
    @if (session()->has('success'))
        <div class="alert alert--success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== FILTER BAR ===== --}}
    <div class="filter-bar">
        <div class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari foto..." class="search-input">
        </div>

        <select wire:model.live="filterCategory" class="filter-select">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>

        <div class="view-toggle">
            <button wire:click="$set('viewMode', 'grid')" class="view-btn {{ $viewMode === 'grid' ? 'active' : '' }}" title="Grid View">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </button>
            <button wire:click="$set('viewMode', 'list')" class="view-btn {{ $viewMode === 'list' ? 'active' : '' }}" title="List View">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </button>
        </div>
    </div>

    {{-- ===== GRID / LIST VIEW ===== --}}
    @if ($galleries->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                </svg>
            </div>
            <h3>Belum ada foto</h3>
            <p>Mulai tambahkan foto pertama ke galeri Anda.</p>
            <button wire:click="openCreateModal" class="btn btn--primary">Tambah Foto Pertama</button>
        </div>
    @else

        {{-- GRID MODE --}}
        @if ($viewMode === 'grid')
        <div class="photo-grid">
            @foreach ($galleries as $item)
            <div class="photo-card" wire:key="gallery-{{ $item->id }}">
                <div class="photo-card__image-wrap" wire:click="openLightbox({{ $item->id }})">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="photo-card__img" loading="lazy">
                    <div class="photo-card__overlay">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                    </div>
                    @if ($item->is_featured)
                        <span class="photo-card__badge">⭐ Unggulan</span>
                    @endif
                    @if ($item->category)
                        <span class="photo-card__category">{{ $item->category }}</span>
                    @endif
                </div>
                <div class="photo-card__body">
                    <h3 class="photo-card__title">{{ $item->title }}</h3>
                    @if ($item->description)
                        <p class="photo-card__desc">{{ Str::limit($item->description, 60) }}</p>
                    @endif
                    <div class="photo-card__actions">
                        <button wire:click="toggleFeatured({{ $item->id }})" class="action-btn {{ $item->is_featured ? 'action-btn--star-active' : 'action-btn--star' }}" title="{{ $item->is_featured ? 'Hapus dari Unggulan' : 'Jadikan Unggulan' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="{{ $item->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </button>
                        <button wire:click="openEditModal({{ $item->id }})" class="action-btn action-btn--edit" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $item->id }})" class="action-btn action-btn--delete" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- LIST MODE --}}
        @else
        <div class="photo-list">
            @foreach ($galleries as $item)
            <div class="photo-list-item" wire:key="list-{{ $item->id }}">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="photo-list-item__thumb" wire:click="openLightbox({{ $item->id }})">
                <div class="photo-list-item__info">
                    <div class="photo-list-item__top">
                        <h3>{{ $item->title }}</h3>
                        <div class="photo-list-item__meta">
                            @if ($item->category)
                                <span class="tag">{{ $item->category }}</span>
                            @endif
                            @if ($item->is_featured)
                                <span class="tag tag--featured">⭐ Unggulan</span>
                            @endif
                        </div>
                    </div>
                    @if ($item->description)
                        <p class="photo-list-item__desc">{{ $item->description }}</p>
                    @endif
                    <span class="photo-list-item__date">{{ $item->created_at->format('d M Y') }}</span>
                </div>
                <div class="photo-list-item__actions">
                    <button wire:click="toggleFeatured({{ $item->id }})" class="action-btn {{ $item->is_featured ? 'action-btn--star-active' : 'action-btn--star' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="{{ $item->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </button>
                    <button wire:click="openEditModal({{ $item->id }})" class="action-btn action-btn--edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button wire:click="confirmDelete({{ $item->id }})" class="action-btn action-btn--delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- PAGINATION --}}
        <div class="pagination-wrap">
            {{ $galleries->links() }}
        </div>
    @endif


    {{-- ===== MODAL TAMBAH / EDIT ===== --}}
    @if ($showModal)
    <div class="modal-backdrop" wire:click.self="$set('showModal', false)">
        <div class="modal">
            <div class="modal__header">
                <h2>{{ $editingId ? 'Edit Foto' : 'Tambah Foto Baru' }}</h2>
                <button wire:click="$set('showModal', false)" class="modal__close">&times;</button>
            </div>
            <div class="modal__body">
                <form wire:submit="save">

                    {{-- Upload Area --}}
                    <div class="form-group">
                        <label class="form-label">Foto <span class="required">*</span></label>
                        <div class="upload-area" x-data="{ isDragging: false }"
                             @dragover.prevent="isDragging = true"
                             @dragleave.prevent="isDragging = false"
                             @drop.prevent="isDragging = false">

                            @if ($photo)
                                <div class="upload-preview">
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="upload-preview__img">
                                    <button type="button" wire:click="$set('photo', null)" class="upload-preview__remove">&times;</button>
                                </div>
                            @elseif ($editingId && isset($galleries))
                                @php $currentItem = \App\Models\Gallery::find($editingId); @endphp
                                @if ($currentItem)
                                <div class="upload-preview upload-preview--existing">
                                    <img src="{{ asset('storage/' . $currentItem->image_path) }}" alt="Current" class="upload-preview__img">
                                    <p class="upload-preview__hint">Unggah foto baru untuk mengganti</p>
                                </div>
                                @endif
                            @else
                                <label for="photo-upload" class="upload-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                                    <p>Klik untuk pilih foto atau seret ke sini</p>
                                    <span>PNG, JPG, WEBP — Maks. 2MB</span>
                                </label>
                            @endif

                            <input id="photo-upload" wire:model="photo" type="file" accept="image/*" class="upload-input">
                        </div>
                        @error('photo') <span class="form-error">{{ $message }}</span> @enderror

                        {{-- Upload progress --}}
                        <div wire:loading wire:target="photo" class="upload-progress">
                            <div class="upload-progress__bar"></div>
                            <span>Mengunggah...</span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label">Judul <span class="required">*</span></label>
                        <input wire:model="title" type="text" class="form-input" placeholder="Masukkan judul foto">
                        @error('title') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea wire:model="description" class="form-input form-textarea" rows="3" placeholder="Deskripsi singkat (opsional)"></textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Category --}}
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <input wire:model="category" type="text" class="form-input" placeholder="Contoh: Alam, Budaya, Wisata...">
                        @error('category') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    {{-- Featured toggle --}}
                    <div class="form-group form-group--inline">
                        <label class="toggle-label">
                            <span>Jadikan Foto Unggulan</span>
                            <div class="toggle" wire:click="$toggle('is_featured')">
                                <div class="toggle__track {{ $is_featured ? 'toggle__track--on' : '' }}">
                                    <div class="toggle__thumb {{ $is_featured ? 'toggle__thumb--on' : '' }}"></div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="modal__footer">
                        <button type="button" wire:click="$set('showModal', false)" class="btn btn--secondary">Batal</button>
                        <button type="submit" class="btn btn--primary" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Tambah Foto' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif


    {{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
    @if ($showDeleteModal)
    <div class="modal-backdrop" wire:click.self="$set('showDeleteModal', false)">
        <div class="modal modal--sm">
            <div class="modal__header modal__header--danger">
                <h2>Hapus Foto</h2>
                <button wire:click="$set('showDeleteModal', false)" class="modal__close">&times;</button>
            </div>
            <div class="modal__body">
                <div class="delete-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p>Foto ini akan dihapus permanen dan tidak bisa dikembalikan.</p>
                </div>
            </div>
            <div class="modal__footer">
                <button wire:click="$set('showDeleteModal', false)" class="btn btn--secondary">Batal</button>
                <button wire:click="delete" class="btn btn--danger">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif


    {{-- ===== LIGHTBOX ===== --}}
    @if ($showLightbox && $lightboxItem)
    <div class="lightbox" wire:click.self="$set('showLightbox', false)">
        <button wire:click="$set('showLightbox', false)" class="lightbox__close">&times;</button>
        <div class="lightbox__content">
            <img src="{{ asset('storage/' . $lightboxItem->image_path) }}" alt="{{ $lightboxItem->title }}" class="lightbox__img">
            <div class="lightbox__info">
                <h3>{{ $lightboxItem->title }}</h3>
                @if ($lightboxItem->category)
                    <span class="tag">{{ $lightboxItem->category }}</span>
                @endif
                @if ($lightboxItem->description)
                    <p>{{ $lightboxItem->description }}</p>
                @endif
                <span class="lightbox__date">{{ $lightboxItem->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
    @endif

</div>


{{-- ===== STYLES ===== --}}
@once
@push('styles')
<style>
    .gallery-wrapper {
        padding: 1.5rem;
        max-width: 1280px;
        margin: 0 auto;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* HEADER */
    .gallery-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .gallery-header__left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .gallery-header__title {
        display: flex; align-items: center; gap: 0.5rem;
        font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;
    }
    .gallery-header__stats { display: flex; gap: 0.5rem; }
    .stat-badge {
        background: #f1f5f9; color: #475569;
        padding: 0.25rem 0.75rem; border-radius: 999px;
        font-size: 0.8rem; font-weight: 500;
    }
    .stat-badge--featured { background: #fef9c3; color: #854d0e; }

    /* BUTTONS */
    .btn {
        display: inline-flex; align-items: center; gap: 0.4rem;
        padding: 0.55rem 1.1rem; border-radius: 8px;
        font-size: 0.875rem; font-weight: 600; cursor: pointer;
        border: none; transition: all 0.15s;
    }
    .btn--primary { background: #2563eb; color: white; }
    .btn--primary:hover { background: #1d4ed8; }
    .btn--primary:disabled { opacity: 0.7; cursor: not-allowed; }
    .btn--secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn--secondary:hover { background: #e2e8f0; }
    .btn--danger { background: #ef4444; color: white; }
    .btn--danger:hover { background: #dc2626; }

    /* ALERT */
    .alert {
        display: flex; align-items: center; gap: 0.5rem;
        padding: 0.75rem 1rem; border-radius: 8px;
        margin-bottom: 1rem; font-size: 0.875rem;
    }
    .alert--success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    /* FILTER BAR */
    .filter-bar {
        display: flex; align-items: center; gap: 0.75rem;
        flex-wrap: wrap; margin-bottom: 1.5rem;
        padding: 1rem; background: #f8fafc;
        border: 1px solid #e2e8f0; border-radius: 12px;
    }
    .search-box {
        display: flex; align-items: center; gap: 0.5rem;
        background: white; border: 1px solid #e2e8f0;
        border-radius: 8px; padding: 0.5rem 0.75rem;
        flex: 1; min-width: 200px;
    }
    .search-box svg { color: #94a3b8; flex-shrink: 0; }
    .search-input { border: none; outline: none; font-size: 0.875rem; width: 100%; }
    .filter-select {
        padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0;
        border-radius: 8px; font-size: 0.875rem; background: white;
        color: #374151; cursor: pointer;
    }
    .view-toggle { display: flex; gap: 0.25rem; margin-left: auto; }
    .view-btn {
        padding: 0.5rem; border: 1px solid #e2e8f0;
        border-radius: 6px; background: white; cursor: pointer;
        color: #94a3b8; transition: all 0.15s;
    }
    .view-btn.active { background: #2563eb; color: white; border-color: #2563eb; }
    .view-btn:hover:not(.active) { background: #f1f5f9; }

    /* PHOTO GRID */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
    }
    .photo-card {
        background: white; border: 1px solid #e2e8f0;
        border-radius: 12px; overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .photo-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1); transform: translateY(-2px); }
    .photo-card__image-wrap {
        position: relative; aspect-ratio: 4/3;
        overflow: hidden; cursor: pointer;
    }
    .photo-card__img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .photo-card:hover .photo-card__img { transform: scale(1.05); }
    .photo-card__overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.35);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.2s;
    }
    .photo-card:hover .photo-card__overlay { opacity: 1; }
    .photo-card__badge {
        position: absolute; top: 0.5rem; left: 0.5rem;
        background: rgba(255,200,0,0.9); color: #78350f;
        font-size: 0.7rem; font-weight: 700;
        padding: 0.2rem 0.5rem; border-radius: 999px;
    }
    .photo-card__category {
        position: absolute; bottom: 0.5rem; left: 0.5rem;
        background: rgba(0,0,0,0.6); color: white;
        font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 4px;
    }
    .photo-card__body { padding: 0.875rem; }
    .photo-card__title { font-size: 0.9rem; font-weight: 600; color: #1e293b; margin: 0 0 0.25rem; }
    .photo-card__desc { font-size: 0.78rem; color: #64748b; margin: 0 0 0.75rem; }
    .photo-card__actions { display: flex; gap: 0.4rem; }

    /* ACTION BUTTONS */
    .action-btn {
        padding: 0.35rem; border-radius: 6px;
        border: 1px solid #e2e8f0; background: #f8fafc;
        cursor: pointer; transition: all 0.15s;
        display: flex; align-items: center; justify-content: center;
    }
    .action-btn--star { color: #94a3b8; }
    .action-btn--star:hover { background: #fef9c3; border-color: #fbbf24; color: #f59e0b; }
    .action-btn--star-active { color: #f59e0b; background: #fef9c3; border-color: #fbbf24; }
    .action-btn--edit { color: #3b82f6; }
    .action-btn--edit:hover { background: #eff6ff; border-color: #93c5fd; }
    .action-btn--delete { color: #ef4444; }
    .action-btn--delete:hover { background: #fef2f2; border-color: #fca5a5; }

    /* PHOTO LIST */
    .photo-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .photo-list-item {
        display: flex; align-items: center; gap: 1rem;
        background: white; border: 1px solid #e2e8f0;
        border-radius: 10px; padding: 0.875rem;
        transition: box-shadow 0.2s;
    }
    .photo-list-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.07); }
    .photo-list-item__thumb {
        width: 80px; height: 64px; object-fit: cover;
        border-radius: 8px; flex-shrink: 0; cursor: pointer;
    }
    .photo-list-item__info { flex: 1; min-width: 0; }
    .photo-list-item__top { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.25rem; }
    .photo-list-item__top h3 { font-size: 0.9rem; font-weight: 600; color: #1e293b; margin: 0; }
    .photo-list-item__meta { display: flex; gap: 0.35rem; }
    .photo-list-item__desc { font-size: 0.8rem; color: #64748b; margin: 0 0 0.25rem; }
    .photo-list-item__date { font-size: 0.75rem; color: #94a3b8; }
    .photo-list-item__actions { display: flex; gap: 0.4rem; flex-shrink: 0; }

    .tag {
        background: #e0f2fe; color: #0369a1;
        font-size: 0.7rem; font-weight: 600;
        padding: 0.15rem 0.5rem; border-radius: 999px;
    }
    .tag--featured { background: #fef9c3; color: #92400e; }

    /* EMPTY STATE */
    .empty-state {
        text-align: center; padding: 4rem 2rem;
        color: #94a3b8;
    }
    .empty-state__icon { margin-bottom: 1rem; }
    .empty-state h3 { font-size: 1.1rem; color: #475569; margin-bottom: 0.5rem; }
    .empty-state p { font-size: 0.875rem; margin-bottom: 1.5rem; }

    /* PAGINATION */
    .pagination-wrap { margin-top: 1.5rem; display: flex; justify-content: center; }

    /* MODAL */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 50;
        background: rgba(0,0,0,0.5); backdrop-filter: blur(2px);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
    }
    .modal {
        background: white; border-radius: 16px; width: 100%;
        max-width: 540px; max-height: 90vh; overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .modal--sm { max-width: 400px; }
    .modal__header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9;
    }
    .modal__header h2 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0; }
    .modal__header--danger h2 { color: #dc2626; }
    .modal__close {
        background: none; border: none; font-size: 1.5rem;
        cursor: pointer; color: #94a3b8; line-height: 1;
        padding: 0.25rem; border-radius: 4px;
    }
    .modal__close:hover { background: #f1f5f9; color: #374151; }
    .modal__body { padding: 1.5rem; }
    .modal__footer {
        display: flex; gap: 0.75rem; justify-content: flex-end;
        padding: 1rem 1.5rem; border-top: 1px solid #f1f5f9;
    }

    /* FORM */
    .form-group { margin-bottom: 1.1rem; }
    .form-group--inline { margin-bottom: 0.5rem; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem; }
    .required { color: #ef4444; }
    .form-input {
        width: 100%; padding: 0.6rem 0.875rem;
        border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 0.875rem; color: #1e293b;
        transition: border-color 0.15s; box-sizing: border-box;
    }
    .form-input:focus { outline: none; border-color: #3b82f6; }
    .form-textarea { resize: vertical; min-height: 80px; }
    .form-error { display: block; color: #ef4444; font-size: 0.78rem; margin-top: 0.35rem; }

    /* UPLOAD AREA */
    .upload-area { position: relative; }
    .upload-input { display: none; }
    .upload-placeholder {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 0.5rem;
        padding: 2rem; border: 2px dashed #cbd5e1;
        border-radius: 10px; cursor: pointer; color: #94a3b8;
        transition: all 0.2s; text-align: center;
    }
    .upload-placeholder:hover { border-color: #3b82f6; color: #3b82f6; background: #eff6ff; }
    .upload-placeholder p { font-size: 0.875rem; font-weight: 500; margin: 0; }
    .upload-placeholder span { font-size: 0.75rem; }
    .upload-preview { position: relative; border-radius: 10px; overflow: hidden; }
    .upload-preview__img { width: 100%; max-height: 240px; object-fit: cover; border-radius: 10px; }
    .upload-preview__remove {
        position: absolute; top: 0.5rem; right: 0.5rem;
        background: rgba(0,0,0,0.6); color: white;
        border: none; border-radius: 50%;
        width: 28px; height: 28px; cursor: pointer; font-size: 1rem;
    }
    .upload-preview--existing { border: 2px solid #e2e8f0; }
    .upload-preview__hint {
        text-align: center; font-size: 0.8rem; color: #64748b;
        padding: 0.5rem; background: rgba(255,255,255,0.9); margin: 0;
    }
    .upload-progress {
        margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;
        font-size: 0.8rem; color: #3b82f6;
    }
    .upload-progress__bar {
        flex: 1; height: 4px; background: #e0f2fe;
        border-radius: 2px; overflow: hidden;
        animation: loading 1s infinite;
    }
    @keyframes loading {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* TOGGLE */
    .toggle-label {
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; padding: 0.5rem 0;
    }
    .toggle-label span { font-size: 0.85rem; font-weight: 600; color: #374151; }
    .toggle { display: flex; align-items: center; }
    .toggle__track {
        width: 44px; height: 24px; background: #e2e8f0;
        border-radius: 999px; transition: background 0.2s;
        position: relative; cursor: pointer;
    }
    .toggle__track--on { background: #2563eb; }
    .toggle__thumb {
        position: absolute; top: 3px; left: 3px;
        width: 18px; height: 18px; background: white;
        border-radius: 50%; transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle__thumb--on { transform: translateX(20px); }

    /* DELETE CONFIRM */
    .delete-confirm { text-align: center; padding: 1rem 0; }
    .delete-confirm p { color: #475569; margin-top: 1rem; font-size: 0.9rem; }

    /* LIGHTBOX */
    .lightbox {
        position: fixed; inset: 0; z-index: 100;
        background: rgba(0,0,0,0.9); backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        padding: 2rem;
    }
    .lightbox__close {
        position: absolute; top: 1rem; right: 1rem;
        background: rgba(255,255,255,0.15); color: white;
        border: none; border-radius: 50%;
        width: 40px; height: 40px; font-size: 1.4rem;
        cursor: pointer; transition: background 0.15s;
        display: flex; align-items: center; justify-content: center;
    }
    .lightbox__close:hover { background: rgba(255,255,255,0.3); }
    .lightbox__content {
        display: flex; flex-direction: column; align-items: center;
        max-width: 800px; width: 100%;
    }
    .lightbox__img {
        max-height: 65vh; max-width: 100%;
        object-fit: contain; border-radius: 10px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.5);
    }
    .lightbox__info {
        margin-top: 1rem; text-align: center; color: white;
    }
    .lightbox__info h3 { font-size: 1.1rem; font-weight: 700; margin: 0 0 0.5rem; }
    .lightbox__info p { font-size: 0.875rem; color: #cbd5e1; margin: 0.5rem 0; }
    .lightbox__date { font-size: 0.8rem; color: #64748b; }

    @media (max-width: 640px) {
        .photo-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 0.875rem; }
        .gallery-header { flex-direction: column; align-items: flex-start; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .view-toggle { margin-left: 0; }
    }
</style>
@endpush
@endonce
