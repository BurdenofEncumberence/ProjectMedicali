<nav x-data="{ open: false }" style="background: #085041; border-bottom: 1px solid #0F6E56;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- Left side: Logo + Nav Links --}}
            <div class="flex items-center" style="gap: 40px;">
                <a href="{{ route('dashboard') }}">
                    {{-- Replace logo.png with your actual logo file in public/images/ --}}
                    <img src="{{ asset('images/logo.png') }}" alt="Medicali" class="h-10 w-auto" style="filter: brightness(0) invert(1);">
                </a>
                <div class="hidden sm:flex" style="gap: 8px;">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @role('admin|inventory_manager')
                        <x-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">
                            {{ __('Suppliers') }}
                        </x-nav-link>
                        <x-nav-link :href="route('medicines.index')" :active="request()->routeIs('medicines.*')">
                            {{ __('Medicines') }}
                        </x-nav-link>
                    @endrole

                    @role('admin|pharmacist')
                        <x-nav-link :href="route('prescriptions.index')" :active="request()->routeIs('prescriptions.*')">
                            {{ __('Prescriptions') }}
                        </x-nav-link>
                    @endrole

                    @role('admin|cashier')
                        <x-nav-link :href="route('checkout.index')" :active="request()->routeIs('checkout.*')">
                            {{ __('Checkout') }}
                        </x-nav-link>
                    @endrole

                    @role('admin|cashier|inventory_manager')
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">
                            {{ __('Sales History') }}
                        </x-nav-link>
                    @endrole

                    @role('admin|inventory_manager')
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            {{ __('Reports') }}
                        </x-nav-link>
                    @endrole

                </div>
            </div>

            {{-- Right side: User Dropdown --}}
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
                                style="color: #9FE1CB; border: none; background: transparent;">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger (mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition duration-150 ease-in-out"
                        style="color: #9FE1CB;">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Responsive Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: #085041; border-top: 1px solid #0F6E56;">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            @role('admin|inventory_manager')
                <x-responsive-nav-link :href="route('suppliers.index')" :active="request()->routeIs('suppliers.*')">{{ __('Suppliers') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('medicines.index')" :active="request()->routeIs('medicines.*')">{{ __('Medicines') }}</x-responsive-nav-link>
            @endrole
            @role('admin|pharmacist')
                <x-responsive-nav-link :href="route('prescriptions.index')" :active="request()->routeIs('prescriptions.*')">{{ __('Prescriptions') }}</x-responsive-nav-link>
            @endrole
            @role('admin|cashier')
                <x-responsive-nav-link :href="route('checkout.index')" :active="request()->routeIs('checkout.*')">{{ __('Checkout') }}</x-responsive-nav-link>
            @endrole
            @role('admin|cashier|inventory_manager')
                <x-responsive-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.*')">{{ __('Sales History') }}</x-responsive-nav-link>
            @endrole
            @role('admin|inventory_manager')
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">{{ __('Reports') }}</x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1" style="border-top: 1px solid #0F6E56;">
            <div class="px-4">
                <div class="font-medium text-base" style="color: #E1F5EE;">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm"  style="color: #9FE1CB;">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Nav links — base color */
    nav a, nav button { color: #9FE1CB !important; }
    nav a:hover       { color: #ffffff !important; background: transparent !important; }

    /* Nuclear reset — kill ALL borders/boxes on every nav link state */
    nav a,
    nav a:hover,
    nav a:focus,
    nav a:active,
    nav a[aria-current],
    nav a.border-b-2,
    nav a.border-indigo-400,
    nav a.border-indigo-600,
    nav a.border-transparent,
    nav [class*="border-b"],
    nav [class*="border-indigo"] {
        border: none !important;
        border-bottom: none !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        box-shadow: none !important;
        background: transparent !important;
        outline: none !important;
    }

  
nav a.border-b-2,
nav a[aria-current="page"] {
    color: #ffffff !important;
    background: transparent !important; 
    border-radius: 8px !important;
}   
</style>