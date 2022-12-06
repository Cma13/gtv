<nav x-data="{ open: false }" class="bg-blue-500 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-16 ">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <div>
                    <a href="{{ route('welcome') }}"
                        class="self-center text-2xl font-bold whitespace-nowrap text-white">GTV</a>
                </div>
            </div>
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @hasrole('Administrador|Profesor|Alumno')
                        <x-jet-nav-link href="{{ route('points.index') }}" :active="request()->routeIs('points.index')">
                            Puntos de interés
                        </x-jet-nav-link>
                        @hasanyrole('Administrador|Profesor')
                            <x-jet-nav-link href="{{ route('places.index') }}" :active="request()->routeIs('places.index')">
                                Lugares
                            </x-jet-nav-link>
                        @endhasrole
                        <x-jet-nav-link href="{{ route('videos.index') }}" :active="request()->routeIs('videos.index')">
                            Vídeos
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('photographies.index') }}" :active="request()->routeIs('photographies.index')">
                            Fotografías
                        </x-jet-nav-link>
                        @hasanyrole('Administrador|Profesor')
                            <x-jet-nav-link href="{{ route('thematic-areas.index') }}" :active="request()->routeIs('thematic-areas.index')">
                                Áreas temáticas
                            </x-jet-nav-link>
                            <x-jet-nav-link href="{{ route('visit.index') }}" :active="request()->routeIs('visit.index')">
                                Visitas
                            </x-jet-nav-link>
                        @endhasrole
                        @role('Administrador')
                            <x-jet-nav-link href="{{ route('video-items.index') }}" :active="request()->routeIs('video-items.index')">
                                Vídeo items
                            </x-jet-nav-link>
                            <x-jet-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                                Usuarios
                            </x-jet-nav-link>
                        @endrole
                    @endhasrole
                </div>
                <div class="ml-8 my-auto">
                    @auth
                        @livewire('admin.user-profile')
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
