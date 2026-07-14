<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-teal-600 font-semibold uppercase tracking-widest">
                Discover
            </span>
            <h2 class="text-5xl font-bold mt-3">
                Popular Destinations
            </h2>
            <p class="text-gray-500 mt-4">
                Explore the most beautiful places in East Lombok.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredDestinations as $destination)
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition duration-300">
                    <img
                        src="{{ asset('storage/'.$destination->cover_path) }}"
                        class="w-full h-64 object-cover"
                    >
                    <div class="p-6">
                        <span class="text-sm text-teal-600 font-semibold">
                            {{ $destination->category->name }}
                        </span>
                        <h3 class="text-2xl font-bold mt-2">
                            {{ $destination->name }}
                        </h3>
                        <p class="text-gray-500 mt-3 line-clamp-3">
                            {{ Str::limit($destination->description, 120) }}
                        </p>
                        <div class="flex justify-between items-center mt-6">
                            <span class="text-gray-400">
                                📍 {{ $destination->location }}
                            </span>
                            <a
                                href="{{ route('frontend.destinations.show', $destination) }}"
                                class="text-teal-600 font-semibold hover:underline"
                            >
                                View →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">
                    Belum ada destinasi.
                </div>
            @endforelse
        </div>
    </div>
</section>