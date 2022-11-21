<nav class="bg-blue-500 border-gray-200 px-2 sm:px-4 py-2.5 dark:bg-gray-800">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        <div>
            <a href="{{ route('welcome') }}"
                class="self-center text-2xl font-semibold whitespace-nowrap text-white">GTV</a>
        </div>
        <div class="w-full md:w-auto flex items-center" id="mobile-menu">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-6 md:mt-0 md:text-md md:font-bold">
                <li>
                    <a href="{{ route('points.index') }}"
                        class="block py-2 pr-4 pl-3 {{ request()->routeIs('points.index') ? 'text-sky-700' : 'text-white' }} hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Puntos
                        de Interes</a>
                </li>
                @hasanyrole('Administrador|Profesor')
                    <li>
                        <a href="{{ route('places.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('places.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Lugares</a>
                    </li>
                @endhasanyrole
                <li>
                    <a href="{{ route('videos.index') }}"
                        class="block py-2 pr-4 pl-3 {{ request()->routeIs('videos.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeos</a>
                </li>
                <li>
                    <a href="{{ route('photographies.index') }}"
                        class="block py-2 pr-4 pl-3 {{ request()->routeIs('photographies.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Fotografías</a>
                </li>

                @hasanyrole('Administrador|Profesor')
                    <li>
                        <a href="{{ route('thematic-areas.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('thematic-areas.index') ? 'text-sky-700' : 'text-white' }} border-b
                            border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200
                            md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white
                            md:dark:hover:bg-transparent dark:border-gray-700">
                            Áreas temáticas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('visit.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('visit.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Visitas</a>
                    </li>
                @endhasanyrole

                @role('Administrador')
                    <li>
                        <a href="{{ route('video-items.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('video-items.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeo
                            Items</a>
                    </li>

                    <li>
                        <a href="{{ route('users.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('users.index') ? 'text-sky-700' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Usuarios</a>
                    </li>
                @endrole
            </ul>

            <div class="ml-8">
                @auth
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="relative inline-block">
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->login }}" />
                                        @if (countUserNotifications())
                                        <span
                                            class="absolute bottom-0 right-0 inline-block w-4 h-4 bg-red-600 border-2 border-white rounded-full"></span>                                            
                                        @endif
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-sm text-gray-400">
                                {{ auth()->user()->roles->first()->name }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @hasanyrole('Administrador|Profesor')
                                <x-jet-dropdown-link href="{{ route('verify.index') }}">
                                    {{ __('Verificate') }}
                                    @if (countUserNotifications())
                                    <span
                                        class="inline-flex items-center justify-end px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ countUserNotifications() }}</span>                                        
                                    @endif
                                </x-jet-dropdown-link>
                            @endrole

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                @endauth
            </div>
        </div>
    </div>
</nav>
