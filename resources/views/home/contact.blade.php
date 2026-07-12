<section id="contact" class="py-24 bg-gradient-to-b from-gray-50 to-gray-100/50 relative overflow-hidden">
    {{-- Decorative Background Blur Elements --}}
    <div class="absolute top-1/2 left-0 -translate-y-1/2 w-96 h-96 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="px-4 py-1.5 rounded-full bg-teal-500/10 border border-teal-500/25 text-teal-600 text-sm font-semibold tracking-widest uppercase mb-4 inline-block">
                Get In Touch
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
                Let's Start a Conversation
            </h2>
            <p class="text-lg text-gray-600">
                Have questions about East Lombok destinations, or want to collaborate? Send us a message below.
            </p>
        </div>

        {{-- Contact Grid Layout --}}
        <div class="grid lg:grid-cols-12 gap-12 items-start max-w-6xl mx-auto">
            
            {{-- Left Side: Contact Information Card --}}
            <div class="lg:col-span-5 bg-gradient-to-br from-teal-900 to-gray-900 text-white rounded-3xl p-8 md:p-10 shadow-2xl relative overflow-hidden flex flex-col justify-between h-full">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div>
                    <h3 class="text-2xl font-bold mb-3">Contact Information</h3>
                    <p class="text-gray-300 text-sm mb-10 leading-relaxed">
                        Fill out the form and our team will get back to you within 24 hours.
                    </p>

                    <div class="space-y-6">
                        {{-- Location Info --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0 text-teal-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs uppercase tracking-wider text-teal-400 font-semibold mb-1">Location</h4>
                                <p class="text-gray-200 text-sm leading-relaxed">East Lombok, West Nusa Tenggara, Indonesia</p>
                            </div>
                        </div>

                        {{-- Email Info --}}
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center shrink-0 text-teal-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs uppercase tracking-wider text-teal-400 font-semibold mb-1">Email Us</h4>
                                <p class="text-gray-200 text-sm">support@eastlombokblog.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-white/10 text-xs text-gray-400">
                    &copy; {{ date('Y') }} East Lombok Blog. All rights reserved.
                </div>
            </div>

            {{-- Right Side: Form Card --}}
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-800">
                            Your Name <span class="text-teal-600">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all shadow-sm"
                            placeholder="PAESAL"
                            required>
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-800">
                            Email Address <span class="text-teal-600">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all shadow-sm"
                            placeholder="paesal@example.com"
                            required>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-800">
                            Message <span class="text-teal-600">*</span>
                        </label>
                        <textarea
                            name="message"
                            rows="5"
                            class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"
                            placeholder="How can we help you today?"
                            required>{{ old('message') }}</textarea>
                        @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white font-semibold px-10 py-4 rounded-xl shadow-lg shadow-teal-600/30 hover:shadow-teal-600/50 transition-all duration-300 flex items-center justify-center gap-2 group">
                        Send Message
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>

                </form>
            </div>

        </div>
    </div>
</section>