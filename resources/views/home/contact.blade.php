<section id="contact" class="py-20 bg-gray-100">
    <div class="max-w-4xl mx-auto px-6">

        <h2 class="text-4xl font-bold text-center mb-3">
            Contact Us
        </h2>

        <p class="text-center text-gray-600 mb-10">
            Send us a message if you have questions or suggestions.
        </p>

        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block mb-2 font-medium">
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full border rounded-lg px-4 py-3"
                    placeholder="Your Name"
                    required>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="w-full border rounded-lg px-4 py-3"
                    placeholder="Your Email"
                    required>
            </div>

            <div>
                <label class="block mb-2 font-medium">
                    Message
                </label>

                <textarea
                    name="message"
                    rows="6"
                    class="w-full border rounded-lg px-4 py-3"
                    placeholder="Write your message..."
                    required></textarea>
            </div>

            <button
                type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-lg">
                Send Message
            </button>

        </form>

    </div>
</section>