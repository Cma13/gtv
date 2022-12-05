<nav class="bg-blue-500 border-gray-200 px-2 sm:px-4 py-2.5 dark:bg-gray-800">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        <div>
            <a href="{{ route('welcome') }}"
                class="self-center text-2xl font-semibold whitespace-nowrap text-white">GTV</a>
        </div>
        <div class="w-full md:w-auto flex items-center" id="mobile-menu">
            <ul class="flex flex-col mt-4 md:flex-row md:space-x-6 md:mt-0 md:text-md md:font-bold">
                @hasrole('Administrador|Profesor|Alumno')
                    <li class="{{ request()->routeIs('points.index') ? 'border-b-4 border-sky-900' : '' }}">
                        <a href="{{ route('points.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('points.index') ? 'text-sky-900 border-b-4 border-gray-500' : 'text-white' }} hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Puntos
                            de Interés</a>
                    </li>
                    @hasanyrole('Administrador|Profesor')
                        <li class="{{ request()->routeIs('places.index') ? 'border-b-4 border-sky-900' : '' }}">
                            <a href="{{ route('places.index') }}"
                                class="block py-2 pr-4 pl-3 {{ request()->routeIs('places.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Lugares</a>
                        </li>
                    @endhasanyrole

                    <li class="{{ request()->routeIs('videos.index') ? 'border-b-4 border-sky-900' : '' }}">
                        <a href="{{ route('videos.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('videos.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeos</a>
                    </li>
                    <li class="{{ request()->routeIs('photographies.index') ? 'border-b-4 border-sky-900' : '' }}">
                        <a href="{{ route('photographies.index') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('photographies.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Fotografías</a>
                    </li>

                    @hasanyrole('Administrador|Profesor')
                        <li class="{{ request()->routeIs('thematic-areas.index') ? 'border-b-4 border-sky-900' : '' }}">
                            <a href="{{ route('thematic-areas.index') }}"
                                class="block py-2 pr-4 pl-3 {{ request()->routeIs('thematic-areas.index') ? 'text-sky-900' : 'text-white' }} border-b
                                border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200
                                md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white
                                md:dark:hover:bg-transparent dark:border-gray-700">
                                Áreas temáticas
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('visit.index') ? 'border-b-4 border-sky-900' : '' }}">
                            <a href="{{ route('visit.index') }}"
                                class="block py-2 pr-4 pl-3 {{ request()->routeIs('visit.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Visitas</a>
                        </li>
                    @endhasanyrole

                    @role('Administrador')
                        <li class="{{ request()->routeIs('video-items.index') ? 'border-b-4 border-sky-900' : '' }}">
                            <a href="{{ route('video-items.index') }}"
                                class="block py-2 pr-4 pl-3 {{ request()->routeIs('video-items.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeo
                                Items</a>
                        </li>
                        <li class="{{ request()->routeIs('users.index') ? 'border-b-4 border-sky-900' : '' }}">
                            <a href="{{ route('users.index') }}"
                                class="block py-2 pr-4 pl-3 {{ request()->routeIs('users.index') ? 'text-sky-900' : 'text-white' }} border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Usuarios</a>
                        </li>
                    @endrole
                @endhasrole
            </ul>

            <div class="ml-8">
                @auth
                    @livewire('admin.user-profile')
                @endauth
            </div>
        </div>
    </div>
</nav>
