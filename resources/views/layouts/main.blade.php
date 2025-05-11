<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Website Resmi Desa Pamuruyan' }}</title>
    <meta name="description"
        content="{{ $description ?? 'Website resmi Pemerintah Desa Pamuruyan. Sarana informasi dan komunikasi digital untuk warga desa dan masyarakat umum.' }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Styles -->
    @stack('styles')

    <style>
        [x-cloak] {
            display: none !important;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <!-- Navbar -->
    <header class="bg-white shadow-md z-20 relative" x-data="{ mobileMenuOpen: false, searchOpen: false }">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('front.index') }}" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Desa" class="h-12 w-auto mr-3">
                        <div>
                            <h1 class="font-bold text-lg text-lime-800 leading-none">DESA PAMURUYAN</h1>
                            <p class="text-xs text-gray-500">Website Resmi Pemerintah Desa</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('front.index') }}"
                        class="text-gray-700 hover:text-lime-600 font-medium">Beranda</a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center text-gray-700 hover:text-lime-600 font-medium">
                            <span>Profil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak
                            class="absolute z-10 -left-4 mt-2 bg-white rounded-md shadow-lg w-48" x-transition>
                            <a href="{{ route('front.visi-misi') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-lime-50 hover:text-lime-600">Visi &
                                Misi</a>
                            <a href="{{ route('front.kepengurusan') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-lime-50 hover:text-lime-600">Struktur
                                Pemerintahan</a>
                        </div>
                    </div>

                    <a href="{{ route('front.berita.index') }}"
                        class="text-gray-700 hover:text-lime-600 font-medium">Berita</a>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center text-gray-700 hover:text-lime-600 font-medium">
                            <span>Pelayanan</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak
                            class="absolute z-10 -left-4 mt-2 bg-white rounded-md shadow-lg w-48" x-transition>
                            <a href="{{ route('front.layanan-surat') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-lime-50 hover:text-lime-600">Layanan
                                Surat</a>
                            <a href="{{ route('front.jadwal-kegiatan') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-lime-50 hover:text-lime-600">Jadwal
                                Kegiatan</a>
                        </div>
                    </div>

                    <a href="{{ route('front.galeri') }}"
                        class="text-gray-700 hover:text-lime-600 font-medium">Galeri</a>
                </nav>

                <!-- Search button -->
                <div class="hidden md:flex items-center space-x-4">
                    <button @click="searchOpen = !searchOpen" class="text-gray-600 hover:text-lime-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <a href="{{ route('login') }}"
                        class="bg-lime-600 hover:bg-lime-700 text-white px-4 py-2 rounded-md text-sm font-medium">Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-lime-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-white border-t" x-transition>
            <div class="container mx-auto px-4 py-3 space-y-1">
                <a href="{{ route('front.index') }}"
                    class="block py-2 text-gray-700 hover:text-lime-600 font-medium">Beranda</a>

                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-2 text-gray-700 hover:text-lime-600 font-medium">
                        <span>Profil</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-4 space-y-1" x-transition>
                        <a href="{{ route('front.visi-misi') }}"
                            class="block py-2 text-gray-700 hover:text-lime-600">Visi
                            &
                            Misi</a>
                        <a href="{{ route('front.kepengurusan') }}"
                            class="block py-2 text-gray-700 hover:text-lime-600">Struktur Pemerintahan</a>
                    </div>
                </div>

                <a href="{{ route('front.berita.index') }}"
                    class="block py-2 text-gray-700 hover:text-lime-600 font-medium">Berita</a>

                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-2 text-gray-700 hover:text-lime-600 font-medium">
                        <span>Pelayanan</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="pl-4 space-y-1" x-transition>
                        <a href="{{ route('front.layanan-surat') }}"
                            class="block py-2 text-gray-700 hover:text-lime-600">Layanan Surat</a>
                        <a href="{{ route('front.jadwal-kegiatan') }}"
                            class="block py-2 text-gray-700 hover:text-lime-600">Jadwal Kegiatan</a>
                    </div>
                </div>

                <a href="{{ route('front.galeri') }}"
                    class="block py-2 text-gray-700 hover:text-lime-600 font-medium">Galeri</a>
                <a href="{{ route('login') }}" class="block py-2 text-lime-600 font-medium">Login</a>
            </div>
        </div>

        <!-- Search overlay -->
        <div x-show="searchOpen" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-30"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="h-full flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                    <div class="p-4 flex items-center border-b">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" placeholder="Cari informasi..." class="w-full outline-none text-lg">
                        <button @click="searchOpen = false" class="ml-4 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-lime-900 text-white">
        <div class="container mx-auto px-4 md:px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Desa Pamuruyan</h3>
                    <p class="mb-4 text-lime-100">Jl. Pamuruyan-Leuweung datar No.3<br>Kecamatan Cibadak<br>Kabupaten
                        Sukabumi<br>Provinsi Jawa Barat</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-lime-100 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-lime-100 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-lime-100 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#" class="text-lime-100 hover:text-white">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Link Terkait</h3>
                    <ul class="space-y-2">
                        <li><a href="https://kemendesa.go.id" target="_blank"
                                class="text-lime-100 hover:text-white">Kementerian
                                Desa PDTT</a></li>
                        <li><a href="https://kemendagri.go.id" target="_blank"
                                class="text-lime-100 hover:text-white">Kementerian
                                Dalam Negeri</a></li>
                        <li><a href="https://web.sukabumikab.go.id/web" target="_blank"
                                class="text-lime-100 hover:text-white">Website Kabupaten</a></li>
                        <li><a href="https://kec-cibadak.sukabumikab.go.id" target="_blank"
                                class="text-lime-100 hover:text-white">Website Kecamatan</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4">Hubungi Kami</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-lime-100 mr-2 mt-0.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-lime-100">+0822-1932-0267</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-lime-100 mr-2 mt-0.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-lime-100">desa.pamuruyan@gmail.com</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-lime-100 mr-2 mt-0.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-lime-100">Jl. Pamuruyan-Leuweung datar No.3, Pamuruyan, Kec. Cibadak,
                                Kabupaten Sukabumi, Jawa Barat 43351</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-lime-800 text-center">
                <p class="text-lime-100">&copy; {{ date('Y') }} Desa Pamuruyan - Kecamatan Cibadak.</p>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button id="backToTop"
        class="fixed bottom-8 right-8 bg-lime-600 text-white p-2 rounded-full shadow-lg z-20 opacity-0 transition-opacity duration-300"
        onclick="scrollToTop()">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- Scripts -->
    <script>
        // Show/hide back to top button
        window.addEventListener('scroll', function() {
            var backToTopButton = document.getElementById('backToTop');
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0');
                backToTopButton.classList.add('opacity-100');
            } else {
                backToTopButton.classList.remove('opacity-100');
                backToTopButton.classList.add('opacity-0');
            }
        });

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
