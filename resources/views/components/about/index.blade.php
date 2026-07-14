<div class="max-w-6xl mx-auto space-y-8">

    {{-- Header --}}
    <div>
        <flux:heading size="xl">
            About Website
        </flux:heading>

        <flux:text class="mt-2 text-zinc-500">
            Manage your website information.
        </flux:text>
    </div>

    @if(session()->has('success'))
        <div class="rounded-lg bg-green-100 text-green-700 p-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-8">

        {{-- Banner --}}
        <div class="rounded-xl border p-6 bg-white shadow-sm">

            <h2 class="text-lg font-semibold mb-4">
                Banner Image
            </h2>

            @if($image)

                <img
                    src="{{ $image->temporaryUrl() }}"
                    class="w-full h-72 rounded-xl object-cover border">

            @elseif($about->image)

                <img
                    src="{{ asset('storage/'.$about->image) }}"
                    class="w-full h-72 rounded-xl object-cover border">

            @else

                <div class="h-72 rounded-xl border-2 border-dashed flex items-center justify-center text-zinc-400">
                    No Image
                </div>

            @endif

            <div class="mt-5">

                <input
                    type="file"
                    wire:model="image"
                    class="block w-full border rounded-lg p-2">

                @error('image')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>

        {{-- Website Information --}}
        <div class="rounded-xl border p-6 bg-white shadow-sm space-y-5">

            <h2 class="text-lg font-semibold">
                Website Information
            </h2>

            <flux:input
                label="Website Title"
                wire:model="title"/>

            @error('title')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <flux:textarea
                label="Short Description"
                wire:model="short_description"/>

            @error('short_description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <flux:textarea
                label="Description"
                wire:model="description"
                rows="6"/>

            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

        </div>

        {{-- Vision Mission --}}
        <div class="rounded-xl border p-6 bg-white shadow-sm space-y-5">

            <h2 class="text-lg font-semibold">
                Vision & Mission
            </h2>

            <flux:textarea
                label="Vision"
                wire:model="vision"
                rows="5"/>

            @error('vision')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <flux:textarea
                label="Mission"
                wire:model="mission"
                rows="6"/>

            @error('mission')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

        </div>

        {{-- Contact --}}
        <div class="rounded-xl border p-6 bg-white shadow-sm space-y-5">

            <h2 class="text-lg font-semibold">
                Contact Information
            </h2>

            <flux:input
                label="Address"
                wire:model="address"/>

            <flux:input
                label="Phone"
                wire:model="phone"/>

            <flux:input
                label="Email"
                wire:model="email"/>

        </div>

        {{-- Social --}}
        <div class="rounded-xl border p-6 bg-white shadow-sm space-y-5">

            <h2 class="text-lg font-semibold">
                Social Media
            </h2>

            <flux:input
                label="Facebook"
                wire:model="facebook"/>

            <flux:input
                label="Instagram"
                wire:model="instagram"/>

            <flux:input
                label="Youtube"
                wire:model="youtube"/>

        </div>

        {{-- Save --}}
        <div class="flex justify-end">

            <flux:button
                type="submit"
                variant="primary"
                icon="check">

                Save Changes

            </flux:button>

        </div>

    </form>

</div>