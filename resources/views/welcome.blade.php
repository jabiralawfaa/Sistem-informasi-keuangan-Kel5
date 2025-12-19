<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sistem Informasi Keuangan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- GSAP CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    </head>
    <body class="bg-black text-gray-100 min-h-screen font-sans relative overflow-x-hidden">
        <!-- Animated Background Particles -->
        <div id="particles-js" class="absolute inset-0 z-0"></div>

        <div class="container mx-auto px-4 py-8 relative z-10">
            <!-- Hero Section -->
            <section id="hero" class="min-h-screen flex flex-col justify-center items-center text-center px-4 relative">
                <div class="absolute top-10 right-10 w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
                <div class="absolute bottom-20 left-10 w-1 h-1 bg-amber-500 rounded-full animate-ping"></div>
                <div class="absolute top-1/3 left-1/4 w-1.5 h-1.5 bg-amber-300 rounded-full animate-pulse"></div>

                <h1 class="text-5xl md:text-7xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 relative">
                    Sistem Informasi Keuangan
                    <span class="absolute -top-2 -right-6 text-2xl animate-bounce">✨</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 max-w-3xl text-gray-300 relative">
                    Solusi lengkap untuk pengelolaan transaksi keuangan dan pencatatan kas dengan fitur canggih
                </p>
                <div class="flex flex-col sm:flex-row gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="px-10 py-4 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-amber-500/20 border border-amber-500"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="px-10 py-4 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-amber-500/20 border border-amber-500"
                            >
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="px-10 py-4 bg-black hover:bg-gray-900 text-amber-400 font-bold rounded-xl transition-all duration-300 transform hover:scale-105 border-2 border-amber-500 hover:border-amber-400"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-20 px-4 relative">
                <div class="absolute top-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
                <h2 class="text-4xl font-bold text-center mb-16 text-amber-400 relative">
                    <span class="relative">Fitur Utama</span>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-0.5 bg-amber-500"></div>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="text-amber-400 text-5xl mb-6 transition-transform duration-300 group-hover:scale-110">💰</div>
                        <h3 class="text-xl font-bold mb-4 text-amber-400">Pencatatan Transaksi</h3>
                        <p class="text-gray-300">Catat semua pemasukan dan pengeluaran dengan mudah dan rapi</p>
                        <div class="absolute top-0 right-0 w-16 h-16 bg-amber-500/10 rounded-full -mt-8 -mr-8 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="text-amber-400 text-5xl mb-6 transition-transform duration-300 group-hover:scale-110">📊</div>
                        <h3 class="text-xl font-bold mb-4 text-amber-400">Laporan Keuangan</h3>
                        <p class="text-gray-300">Laporan bulanan yang komprehensif untuk analisis keuangan</p>
                        <div class="absolute top-0 right-0 w-16 h-16 bg-amber-500/10 rounded-full -mt-8 -mr-8 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="text-amber-400 text-5xl mb-6 transition-transform duration-300 group-hover:scale-110">🖨️</div>
                        <h3 class="text-xl font-bold mb-4 text-amber-400">Kwitansi Digital</h3>
                        <p class="text-gray-300">Cetak kwitansi digital dengan format yang profesional</p>
                        <div class="absolute top-0 right-0 w-16 h-16 bg-amber-500/10 rounded-full -mt-8 -mr-8 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="text-amber-400 text-5xl mb-6 transition-transform duration-300 group-hover:scale-110">💰</div>
                        <h3 class="text-xl font-bold mb-4 text-amber-400">Monitoring Saldo</h3>
                        <p class="text-gray-300">Pantau saldo kas secara real-time dan akurat</p>
                        <div class="absolute top-0 right-0 w-16 h-16 bg-amber-500/10 rounded-full -mt-8 -mr-8 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>
                </div>
            </section>

            <!-- Roles Section -->
            <section id="roles" class="py-20 px-4 relative">
                <div class="absolute top-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
                <h2 class="text-4xl font-bold text-center mb-16 text-amber-400 relative">
                    <span class="relative">Hak Akses Pengguna</span>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-0.5 bg-amber-500"></div>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <!-- Admin -->
                    <div class="role-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <h3 class="text-2xl font-bold mb-6 text-amber-400">Admin Keuangan</h3>
                        <ul class="space-y-4 text-gray-300">
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Akses penuh ke semua fitur</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Kelola pengguna dan hak akses</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Generate laporan lengkap</span>
                            </li>
                        </ul>
                        <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/10 rounded-full -mt-10 -mr-10 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>

                    <!-- Bendahara -->
                    <div class="role-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <h3 class="text-2xl font-bold mb-6 text-amber-400">Bendahara</h3>
                        <ul class="space-y-4 text-gray-300">
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Input transaksi keuangan</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Pantau saldo kas</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Cetak kwitansi</span>
                            </li>
                        </ul>
                        <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/10 rounded-full -mt-10 -mr-10 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>

                    <!-- Auditor -->
                    <div class="role-card p-8 bg-gradient-to-br from-gray-900 to-black rounded-2xl border border-amber-900/50 hover:border-amber-600 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-xl hover:shadow-amber-500/10 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <h3 class="text-2xl font-bold mb-6 text-amber-400">Auditor</h3>
                        <ul class="space-y-4 text-gray-300">
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Akses laporan keuangan</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Verifikasi transaksi</span>
                            </li>
                            <li class="flex items-start group/item">
                                <span class="text-amber-400 mr-3 text-xl transition-transform duration-300 group-hover/item:translate-x-1">✓</span>
                                <span>Monitoring histori</span>
                            </li>
                        </ul>
                        <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/10 rounded-full -mt-10 -mr-10 transition-transform duration-500 group-hover:scale-150"></div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section id="cta" class="py-20 text-center relative">
                <div class="absolute top-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
                <h2 class="text-4xl font-bold mb-6 text-amber-400">Siap Mengelola Keuangan Anda?</h2>
                <p class="text-xl mb-10 max-w-2xl mx-auto text-gray-300">
                    Bergabunglah dengan ribuan pengguna yang telah mengoptimalkan manajemen keuangan mereka
                </p>
                <a
                    href="{{ route('register') }}"
                    class="px-12 py-5 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold text-xl rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-amber-500/30 border border-amber-500 inline-block relative overflow-hidden group"
                >
                    <span class="relative z-10">Mulai Sekarang</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-700/0 via-amber-700/20 to-amber-700/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>
            </section>
        </div>

        <footer class="py-10 text-center border-t border-amber-900/30 text-gray-400 relative">
            <div class="absolute top-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent"></div>
            <p>&copy; {{ date('Y') }} Sistem Informasi Keuangan. Hak Cipta Dilindungi.</p>
        </footer>

        <!-- Particles.js -->
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

        <script>
            // Initialize particles.js
            particlesJS("particles-js", {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: "#D4AF37" },
                    shape: { type: "circle" },
                    opacity: { value: 0.5, random: true },
                    size: { value: 3, random: true },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#D4AF37",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: "none",
                        random: true,
                        straight: false,
                        out_mode: "out",
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: { enable: true, mode: "repulse" },
                        onclick: { enable: true, mode: "push" },
                        resize: true
                    }
                },
                retina_detect: true
            });

            // Register GSAP plugins
            gsap.registerPlugin(ScrollTrigger);

            // Hero section animation
            gsap.from("#hero h1", {
                duration: 1.5,
                y: 100,
                opacity: 0,
                ease: "power3.out"
            });

            gsap.from("#hero p", {
                duration: 1.5,
                y: 50,
                opacity: 0,
                ease: "power3.out",
                delay: 0.3
            });

            gsap.from("#hero .flex", {
                duration: 1.5,
                y: 50,
                opacity: 0,
                ease: "power3.out",
                delay: 0.6
            });

            // Features section animation
            gsap.utils.toArray('.feature-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "play none none reverse"
                    },
                    duration: 1,
                    y: 100,
                    opacity: 0,
                    delay: i * 0.15,
                    ease: "power2.out"
                });
            });

            // Roles section animation
            gsap.utils.toArray('.role-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: "top 85%",
                        toggleActions: "play none none reverse"
                    },
                    duration: 1,
                    y: 100,
                    opacity: 0,
                    delay: i * 0.2,
                    ease: "power2.out"
                });
            });

            // Animate CTA section
            gsap.from("#cta", {
                scrollTrigger: {
                    trigger: "#cta",
                    start: "top 85%",
                    toggleActions: "play none none reverse"
                },
                duration: 1.2,
                y: 80,
                opacity: 0,
                ease: "power2.out"
            });
        </script>
    </body>
</html>