<nav id="Navbar" class="max-w-[1130px] mx-auto flex justify-between items-center mt-[30px] gap-x-2">
    <div class="logo-container flex gap-[30px] items-center">
        <a href="{{ route('front.index') }}" class="flex shrink-0">
            <img src="{{ asset('images/logo-kab-sukabumi.png') }}" class="w-10 object-cover" alt="logo" />
        </a>
        <div class="h-12 border border-[#E8EBF4]"></div>
        <form method="GET" action="{{ route('front.search') }}"
            class="w-[450px] flex items-center rounded-full border border-[#E8EBF4] p-[12px_20px] gap-[10px] focus-within:ring-2 focus-within:ring-lime-600 transition-all duration-300">
            @csrf

            <button type="submit" class="w-5 h-5 flex shrink-0">
                <img src="{{ asset('images/search-normal.svg') }}" alt="icon" />
            </button>
            <input type="text" name="keyword" id=""
                class="appearance-none outline-none w-full font-semibold placeholder:font-normal placeholder:text-[#A3A6AE]"
                placeholder="Cari..." />
        </form>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('filament.warga.auth.login') }}"
            class="rounded-full p-[12px_22px] flex gap-[10px] font-semibold transition-all duration-300 border border-[#EEF0F7] hover:ring-2 hover:ring-lime-600">
            Masuk
        </a>
        <a href="{{ route('filament.warga.auth.register') }}"
            class="rounded-full p-[12px_22px] flex gap-[10px] font-bold transition-all duration-300 bg-lime-600 text-white hover:shadow-[0_10px_20px_0_#18FF6580]">
            Register
        </a>
    </div>
</nav>
