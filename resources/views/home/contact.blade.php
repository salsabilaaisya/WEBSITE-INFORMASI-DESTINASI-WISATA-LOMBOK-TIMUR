<section id="contact" class="py-20 bg-gray-100">
    <div class="max-w-4xl mx-auto px-6">

        <h2 class="text-4xl font-bold text-center mb-3">
            Contact Us
        </h2>

        <p class="text-center text-gray-600 mb-10">
            Send us a message if you have questions or suggestions.
        </p>

        @if(session('success'))
            <div class="mb-5 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">

            @csrf

            <div>
                <label class="block mb-2 font-medium">
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full rounded-lg border px-4 py-3"
                    placeholder="Your Name"
                >

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full rounded-lg border px-4 py-3"
                    placeholder="Your Email"
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Message
                </label>

                <textarea
                    name="message"
                    rows="6"
                    class="w-full rounded-lg border px-4 py-3"
                    placeholder="Write your message..."
                >{{ old('message') }}</textarea>

                @error('message')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                type="submit"
                class="rounded-lg bg-teal-600 px-8 py-3 text-white hover:bg-teal-700"
            >
                Send Message
            </button>

        </form>

    </div>
</section>