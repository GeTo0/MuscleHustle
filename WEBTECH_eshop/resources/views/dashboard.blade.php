<x-app-layout>
    <x-slot name="header">
    @if(Auth::user() && Auth::user()->permissions === 'ADMIN')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("You're logged in as ADMIN!") }}
    </h2>
    @else
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __("You're logged in!") }}
    </h2>
    @endif
    </x-slot>

    <div class="h-screen flex justify-center items-center flex-col">
        <div class="text-center mb-8">
            <div class="font-bold text-2xl text-gray-800 dark:text-gray-200 mt-10 mb-4">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500 dark:text-gray-400 mt-10 mb-4">{{ Auth::user()->email }}</div>
        </div>

        <div class="flex flex-col items-center space-y-6">
            <x-responsive-nav-link :href="route('profile.edit')" class="text-lg">
                {{ __('EDIT Profile') }}
            </x-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();" class="text-lg">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>

            <x-responsive-nav-link :href="route('homepage')" class="text-lg">
                {{ __('MAIN PAGE') }}
            </x-responsive-nav-link>
        </div>
    </div>
</x-app-layout>