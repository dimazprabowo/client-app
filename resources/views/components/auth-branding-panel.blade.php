{{--
    Auth Branding Panel - Left/right side panel for guest auth pages.

    Template (boilerplate) context: generic enterprise application shell with
    authentication, role-based access control, and user management.
    Visual language: enterprise blueprint grid + clean feature highlights.

    Uses currentColor so the illustration inherits the white text color
    of the blue gradient panel. Width is fixed for desktop layout.
--}}
<div class="hidden lg:flex lg:w-1/2 xl:w-2/5 bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 dark:from-blue-800 dark:via-blue-900 dark:to-gray-900 p-8 lg:p-12 flex-col justify-between relative overflow-hidden text-white">

    {{-- Subtle blueprint grid overlay --}}
    <div class="absolute inset-0 opacity-[0.07] pointer-events-none" aria-hidden="true">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="bp-grid" x="0" y="0" width="32" height="32" patternUnits="userSpaceOnUse">
                    <path d="M 32 0 L 0 0 0 32" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#bp-grid)"/>
        </svg>
    </div>

    {{-- Top accent line --}}
    <div class="absolute top-0 left-0 right-0 h-1 bg-blue-400/30"></div>

    {{-- Content --}}
    <div class="relative z-10 flex flex-col h-full justify-between">

        {{-- Top Section - Logo & Title --}}
        <div>
            <div class="flex items-center space-x-3 mb-10">
                <div class="w-14 h-14 bg-white rounded-xl flex items-center justify-center shadow-lg p-1.5 overflow-hidden flex-shrink-0">
                    <img src="{{ email_logo_url() }}" alt="Logo" class="w-full h-full object-contain rounded-lg">
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold leading-tight">{{ app_name() }}</h1>
                    <p class="text-sm text-blue-200">PT. Biro Klasifikasi Indonesia</p>
                </div>
            </div>

            {{-- Main headline --}}
            <div class="space-y-4 max-w-lg mb-8">
                <h2 class="text-3xl lg:text-4xl xl:text-[2.75rem] font-bold leading-tight">
                    Enterprise Application<br>Platform
                </h2>
                <p class="text-base lg:text-lg text-blue-100 leading-relaxed">
                    Laravel boilerplate dengan autentikasi, role-based access control,
                    dan manajemen pengguna untuk membangun aplikasi enterprise.
                </p>
            </div>
        </div>

        {{-- Middle Section - Enterprise Platform Illustration --}}
        <div class="my-8 text-blue-50">
            <x-auth-platform-illustration />
        </div>

        {{-- Bottom Section - Key Capabilities --}}
        <div class="space-y-3">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500/25 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-white">Authentication & Authorization</h3>
                    <p class="text-xs text-blue-200">Login, register, verifikasi email, reset password</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500/25 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-white">Role-Based Access Control</h3>
                    <p class="text-xs text-blue-200">Manajemen role & permission yang fleksibel</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-500/25 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-sm text-white">User & System Management</h3>
                    <p class="text-xs text-blue-200">CRUD pengguna lengkap & konfigurasi sistem</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="relative z-10 text-blue-200 text-xs mt-6">
        <p>&copy; {{ date('Y') }} {{ app_name() }} &middot; PT. Biro Klasifikasi Indonesia</p>
    </div>
</div>
