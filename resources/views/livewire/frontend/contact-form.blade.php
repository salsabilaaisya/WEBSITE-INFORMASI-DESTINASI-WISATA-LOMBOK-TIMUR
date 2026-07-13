<div>

    {{-- Success Message --}}
    @if(session()->has('success'))

        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                    ✓
                </div>

                <div>

                    <p class="font-semibold text-green-700">
                        Message Sent
                    </p>

                    <p class="text-sm text-green-600">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        </div>

    @endif

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Send Message
        </h2>

        <p class="mt-2 text-slate-500">
            Fill in the form below and we will contact you as soon as possible.
        </p>

    </div>

    <form wire:submit.prevent="send" class="space-y-6">

        {{-- Name --}}
        <div>

            <label class="mb-2 block font-semibold text-slate-700">
                Full Name
            </label>

            <input
                type="text"
                wire:model.live="name"
                placeholder="Enter your name"
                class="w-full rounded-2xl border border-slate-200 px-5 py-4 shadow-sm transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500 outline-none">

            @error('name')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>


        {{-- Email --}}
        <div>

            <label class="mb-2 block font-semibold text-slate-700">
                Email Address
            </label>

            <input
                type="email"
                wire:model.live="email"
                placeholder="example@email.com"
                class="w-full rounded-2xl border border-slate-200 px-5 py-4 shadow-sm transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500 outline-none">

            @error('email')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>


        {{-- Message --}}
        <div>

            <label class="mb-2 block font-semibold text-slate-700">
                Message
            </label>

            <textarea
                rows="6"
                wire:model.live="message"
                placeholder="Write your message..."
                class="w-full rounded-2xl border border-slate-200 px-5 py-4 shadow-sm transition focus:border-teal-500 focus:ring-2 focus:ring-teal-500 outline-none resize-none"></textarea>

            @error('message')

                <p class="mt-2 text-sm text-red-500">

                    {{ $message }}

                </p>

            @enderror

        </div>


        {{-- Button --}}
        <button
            type="submit"
            class="w-full rounded-2xl bg-teal-600 px-6 py-4 text-lg font-semibold text-white transition duration-300 hover:bg-teal-700 hover:shadow-xl">

            Send Message

        </button>

    </form>

</div>