<!-- NAVBAR -->
<nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
    <div class="container">
        <div class="h-18 d-flex justify-content-between align-items-center position-relative">
            <div class="navbar__left d-flex align-items-center"><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title ?? 'Donasi.Co' }}</span>
            </div>
            <div class="navbar__right d-flex align-items-center"></div>
        </div>
    </div>
</nav>
<nav class="position-fixed bottom-4 left-0 w-full z-500">
    <div class="container h-full">
        <div class="shadow-drop rounded-full bg-white h-16 px-4">
            <ul class="d-flex h-full align-items-center justify-content-around">
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="/"><i class="d-block text-xl rck ryd-home"></i><span class="text-xxs">Beranda</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('onboard-campaign') }}"><i class="d-block text-xl rck ryd-campaign"></i><span class="text-xxs">Galang Dana</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('auth-user.onboardLogin') }}"><i class="d-block text-xl rck ryd-history"></i><span class="text-xxs">Riwayat</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-primary" href="{{ route('auth-user.onboardLogin') }}"><i class="d-block text-xl rck ryd-profile"></i><span class="text-xxs">Akun</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav> <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
    <div class="container">
        <div class="h-18 d-flex justify-content-between align-items-center position-relative">
            <div class="navbar__left d-flex align-items-center"><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title ?? 'Donasi.Co' }}</span>
            </div>
            <div class="navbar__right d-flex align-items-center"></div>
        </div>
    </div>
</nav>
<nav class="position-fixed bottom-4 left-0 w-full z-500">
    <div class="container h-full">
        <div class="shadow-drop rounded-full bg-white h-16 px-4">
            <ul class="d-flex h-full align-items-center justify-content-around">
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('frontoffice') }}"><i class="d-block text-xl rck ryd-home"></i><span class="text-xxs">Beranda</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('onboard-campaign') }}"><i class="d-block text-xl rck ryd-campaign"></i><span class="text-xxs">Galang Dana</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('auth-user.onboardLogin') }}"><i class="d-block text-xl rck ryd-history"></i><span class="text-xxs">Riwayat</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-primary" href="{{ route('auth-user.onboardLogin') }}"><i class="d-block text-xl rck ryd-profile"></i><span class="text-xxs">Akun</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>