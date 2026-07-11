<section class="max-w-6xl mx-auto px-6 py-12">

    <span>
        {{ $destination->category->name }}
    </span>

    <h1>
        {{ $destination->name }}
    </h1>

    <p>
        {{ $destination->location }}
    </p>

    <div>
        {{ $destination->description }}
    </div>

</section>

{{-- Gallery --}}
<section class="mt-16">

    <h2 class="text-3xl font-bold text-slate-800 mb-8">
        Gallery
    </h2>

    @if($destination->galleries->count())

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($destination->galleries as $gallery)

                <div class="overflow-hidden rounded-2xl shadow-lg bg-white">

                    <img
                        src="{{ asset('storage/'.$gallery->image) }}"
                        alt="{{ $gallery->caption }}"
                        class="w-full h-64 object-cover hover:scale-105 transition duration-500"
                    >

                    <div class="p-4">

                        <h3 class="font-semibold">

                            {{ $gallery->caption }}

                        </h3>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="rounded-xl bg-slate-100 p-6 text-center text-slate-500">

            Belum ada gallery untuk destinasi ini.

        </div>

    @endif

</section>

<section class="mt-20">

    <h2 class="text-3xl font-bold mb-8">
        Related Destinations
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($related as $item)

            <a
                href="{{ route('frontend.destinations.show',$item) }}"
                class="rounded-2xl overflow-hidden shadow hover:shadow-xl transition bg-white"
            >

                <img
                    src="{{ asset('storage/'.$item->cover_path) }}"
                    class="h-52 w-full object-cover"
                >

                <div class="p-5">

                    <h3 class="font-bold">

                        {{ $item->name }}

                    </h3>

                    <p class="text-sm text-slate-500 mt-2">

                        📍 {{ $item->location }}

                    </p>

                </div>

            </a>

        @endforeach

    </div>

</section>