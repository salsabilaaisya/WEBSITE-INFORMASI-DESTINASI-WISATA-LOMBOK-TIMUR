<div class="space-y-5">

    @if(session()->has('success'))

        <div class="rounded-xl bg-green-100 p-4 text-green-700">

            {{ session('success') }}

        </div>

    @endif

    <form wire:submit.prevent="send" class="space-y-5">

        <input
            type="text"
            wire:model="name"
            placeholder="Your Name"
            class="w-full rounded-xl border px-4 py-3"
        >

        @error('name')

            <p class="text-red-500 text-sm">
                {{ $message }}
            </p>

        @enderror


        <input
            type="email"
            wire:model="email"
            placeholder="Your Email"
            class="w-full rounded-xl border px-4 py-3"
        >

        @error('email')

            <p class="text-red-500 text-sm">
                {{ $message }}
            </p>

        @enderror


        <textarea
            wire:model="message"
            rows="6"
            placeholder="Write your message..."
            class="w-full rounded-xl border px-4 py-3"
        ></textarea>

        @error('message')

            <p class="text-red-500 text-sm">
                {{ $message }}
            </p>

        @enderror


        <button
            type="submit"
            class="rounded-xl bg-teal-600 px-6 py-3 text-white hover:bg-teal-700"
        >

            Send Message

        </button>

    </form>

</div>