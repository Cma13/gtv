<div>
    <x-jet-dropdown align="right" width="48">
        <x-slot name="trigger">
            <span class="relative inline-block">
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->login }}" />
                    @hasanyrole('Administrador|Profesor')
                        @if ($this->countVerifyElements())
                            <span
                                class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-600 border-2 border-white rounded-full"></span>
                        @endif
                    @endrole
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
                    @if ($this->countVerifyElements())
                        <span
                            class="inline-flex items-center justify-end px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $this->countVerifyElements() }}</span>
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
