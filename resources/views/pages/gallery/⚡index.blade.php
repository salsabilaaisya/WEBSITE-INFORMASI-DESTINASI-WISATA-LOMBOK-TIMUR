<div class="p-6">
    @if (session()->has('success'))
        <div style="color:green; margin-bottom: 15px; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" style="margin-bottom: 20px;">
        <input type="text" wire:model="title" placeholder="Judul foto" style="border: 1px solid #ccc; padding: 5px; border-radius: 4px; color: black;">
        <input type="file" wire:model="image">

        @error('image')
            <span style="color:red; display: block;">{{ $message }}</span>
        @enderror

        <button type="submit" style="background-color: #2563eb; color: white; padding: 5px 15px; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px;">
            Upload
        </button>
    </form>

    <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap: 15px;">
        @foreach ($galleries as $item)
            <div style="border:1px solid #ddd; padding:10px; background: #fff;" class="dark:bg-zinc-900 rounded shadow-sm">
                <img src="{{ asset('storage/' . $item->image) }}" width="100%" style="object-fit: cover; height: 200px; border-radius: 4px;">
                <p style="margin-top: 10px;" class="text-sm dark:text-white font-medium">{{ $item->title }}</p>
            </div>
        @endforeach
    </div>
</div>