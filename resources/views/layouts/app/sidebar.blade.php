<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-sidebar-border bg-sidebar">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item> 

                    <flux:sidebar.item icon="tag" :href="route('admin.categories')" :current="request()->routeIs('admin.categories')" wire:navigate>
                        {{ __('Categories') }}
                    </flux:sidebar.item> 

                    <flux:sidebar.item icon="map-pin" :href="route('admin.destinations')" :current="request()->routeIs('admin.destinations')" wire:navigate>
                        {{ __('Destinations') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="newspaper" :href="route('admin.articles.index')" :current="request()->routeIs('admin.articles.index')" wire:navigate>
                        {{ __('Articles') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="photo" :href="route('admin.gallery')" :current="request()->routeIs('admin.gallery')" wire:navigate>
                        {{ __('Gallery') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="envelope" :href="route('admin.messages')" :current="request()->routeIs('admin.messages')" wire:navigate>
                        {{ __('Contact Messages') }}
                    </flux:sidebar.item>

                    <flux:navlist.item icon="information-circle" :href="route('admin.about')" :current="request()->routeIs('admin.about')">
                        {{ __('About') }}
                    </flux:navlist.item>
                
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            @auth
                <x-desktop-user-menu class="hidden lg:block" />
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            @auth
                <flux:dropdown position="top" align="end">

                    <flux:profile
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevron-down"
                    />

                    <flux:menu>

                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar
                                :name="auth()->user()->name"
                                :initials="auth()->user()->initials()"
                            />

                            <div class="grid flex-1">
                                <flux:heading>{{ auth()->user()->name }}</flux:heading>
                                <flux:text>{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>

                        <flux:menu.separator />

                        <flux:menu.item
                            :href="route('profile.edit')"
                            icon="cog"
                            wire:navigate
                        >
                            Settings
                        </flux:menu.item>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                            >
                                Log out
                            </flux:menu.item>
                        </form>

                    </flux:menu>

                </flux:dropdown>
                @endauth
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>