<div>
    <x-jet-dropdown align="right" width="48">
        <x-slot name="trigger">
            <span class="relative inline-block">
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->login }}" />
                    @hasanyrole('Administrador|Profesor')
                        @if ($this->countVerifyElements() || $this->countUnVerifiedUsers())
                            <span
                                class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 border-2 border-white rounded-full"></span>
                        @endif
                    @endrole
                </button>
            </span>
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block">
                <span class="px-4 py-2 text-sm text-black font-bold">{{ auth()->user()->name }}</span>
                <span class="px-4 py-2 text-sm text-gray-400">{{ auth()->user()->roles->first()->name }}</span>
            </div>

            <div class="border-t border-gray-100 my-1"></div>

            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
            </x-jet-dropdown-link>

            @hasrole('Administrador')
                <x-jet-dropdown-link>
                    <button 
                        id="doubleDropdownButton"
                        data-dropdown-toggle="doubleDropdown"
                        data-dropdown-placement="right-start"
                        type="button"
                        class="flex items-center justify-between w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                        {{ __('Tools') }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    <div id="doubleDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="doubleDropdownButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Overview</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">My
                                    downloads</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Billing</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Rewards</a>
                            </li>
                        </ul>
                    </div>
                </x-jet-dropdown-link>
            @endhasrole

            @hasanyrole('Administrador|Profesor')
                <x-jet-dropdown-link href="{{ route('verify.index') }}">
                    {{ __('Verify Posts') }}
                    @if ($this->countVerifyElements())
                        <span
                            class="inline-flex items-center justify-end px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $this->countVerifyElements() }}</span>
                    @endif
                </x-jet-dropdown-link>
                <x-jet-dropdown-link href="{{ route('verify-users.index') }}">
                    {{ __('Verify Users') }}
                    @if ($this->countUnVerifiedUsers())
                        <span
                            class="inline-flex items-center justify-end px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $this->countUnVerifiedUsers() }}</span>
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
</div>
