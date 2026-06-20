<div class="fixed top-4 right-4 z-[9999] w-full max-w-sm space-y-3">
    @foreach (['success', 'error', 'warning', 'info'] as $type)
        @if (session()->has($type))
            @php
                $config = match($type) {
                    'success' => [
                        'title' => 'Berhasil',
                        'icon' => 'check-circle',
                        'iconColor' => 'text-green-500',
                        'border' => 'border-green-200 dark:border-green-800',
                        'bg' => 'bg-green-50 dark:bg-green-950/40',
                    ],
                    'error' => [
                        'title' => 'Gagal',
                        'icon' => 'x-circle',
                        'iconColor' => 'text-red-500',
                        'border' => 'border-red-200 dark:border-red-800',
                        'bg' => 'bg-red-50 dark:bg-red-950/40',
                    ],
                    'warning' => [
                        'title' => 'Peringatan',
                        'icon' => 'exclamation-triangle',
                        'iconColor' => 'text-yellow-500',
                        'border' => 'border-yellow-200 dark:border-yellow-800',
                        'bg' => 'bg-yellow-50 dark:bg-yellow-950/40',
                    ],
                    'info' => [
                        'title' => 'Informasi',
                        'icon' => 'information-circle',
                        'iconColor' => 'text-blue-500',
                        'border' => 'border-blue-200 dark:border-blue-800',
                        'bg' => 'bg-blue-50 dark:bg-blue-950/40',
                    ],
                };
            @endphp

            <div
                x-data="{ show: true, progress: 100 }"
                x-init="
                    let duration = 3000;
                    let start = Date.now();
                    let timer = setInterval(() => {
                        let elapsed = Date.now() - start;
                        progress = 100 - ((elapsed / duration) * 100);
                        if (elapsed >= duration) {
                            show = false;
                            clearInterval(timer);
                        }
                    }, 30);
                "
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-[-10px] scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-[-10px] scale-95"
                class="overflow-hidden rounded-xl border shadow-lg {{ $config['border'] }} {{ $config['bg'] }}"
            >
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 mt-0.5">
                            <flux:icon name="{{ $config['icon'] }}" class="w-5 h-5 {{ $config['iconColor'] }}" />
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-zinc-900 dark:text-white">
                                {{ $config['title'] }}
                            </p>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300 break-words">
                                {{ session($type) }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="show = false"
                            class="shrink-0 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition"
                        >
                            <flux:icon name="x-mark" class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                {{-- progress bar --}}
                <div class="h-1 bg-black/5 dark:bg-white/10">
                    <div
                        class="h-1 bg-current opacity-30 transition-all duration-75"
                        :style="`width: ${progress}%`"
                    ></div>
                </div>
            </div>
        @endif
    @endforeach
</div>