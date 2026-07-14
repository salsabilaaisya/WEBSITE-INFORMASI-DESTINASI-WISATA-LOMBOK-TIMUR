<section id="contact" class="relative py-24 bg-gradient-to-br from-cyan-50 via-white to-teal-50 overflow-hidden">
    
    <!-- Elemen Dekorasi Latar Belakang (Opsional) -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-cyan-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-3/4 h-3/4 bg-teal-100/40 rounded-full blur-3xl translate-x-1/3 translate-y-1/3"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            
            <!-- Kolom Kiri: Teks & Informasi Kontak -->
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-100/80 text-cyan-800 text-sm font-semibold tracking-wide mb-6">
                    <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>
                    Get In Touch
                </div>
                
                <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight">
                    Let's Build Something <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-teal-500">Amazing</span> Together
                </h2>
                
                <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-lg">
                    We value your feedback and are always here to help. Whether you have a project in mind, need support, or just want to say hello, our team is ready to listen.
                </p>

                <!-- Informasi Kontak Tambahan -->
                <div class="mt-10 space-y-6">
                    <!-- Email -->
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100 text-cyan-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Email us at</p>
                            <a href="mailto:Paesal@gmail.com" class="text-lg font-semibold text-slate-800 hover:text-cyan-600 transition-colors">dispar.kab.lotim@gmail.com</a>
                        </div>
                    </div>
                    
                    <!-- Location -->
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100 text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500">Visit our office</p>
                            <p class="text-lg font-semibold text-slate-800">Lombok Timur, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Livewire Form -->
            <div class="relative">
                <!-- Efek bayangan di belakang kartu form -->
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-teal-400 rounded-[2rem] blur-xl opacity-20"></div>
                
                <!-- Kotak Form -->
                <div class="relative bg-white/90 backdrop-blur-xl p-8 sm:p-12 rounded-[2rem] shadow-2xl border border-white/50">
                    <h3 class="text-2xl font-bold text-slate-800 mb-6">Send us a message</h3>
                    
                    <!-- Komponen Livewire Anda -->
                    <livewire:frontend.contact-form />
                    
                </div>
            </div>

        </div>
    </div>
</section>