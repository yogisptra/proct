<div class="h-2 bg-body mx-n8 my-6"></div>
<ul>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('dashboard-myDonation') }}"><i class="rck ryd-heart link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Donasi Saya</span></a>
    </li>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('dashboard-fundraiser') }}"><i class="rck ryd-speaker link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Fundraising</span></a>
    </li>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('dashboard-confirmation_manual') }}"><i class="rck ryd-confirmation link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Konfirmasi Pembayaran</span></a>
    </li>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('dashboard-setting_users') }}"><i class="rck ryd-setting link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Pengaturan</span></a>
    </li>
</ul>
<div class="border-bottom border-gray-light mt-6"></div>
<ul>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.about') }}"><i class="rck ryd-donasico-outline link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Tentang Donasi.co</span></a>
    </li>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.term') }}"><i class="rck ryd-confirmation link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Syarat &amp; Ketentuan</span></a>
    </li>
    <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.faq') }}"><i class="rck ryd-help link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Bantuan</span></a>
    </li>
    <li class="mt-6">
        <a onclick="event.preventDefault();document.getElementById('logout-form-header').submit();" class="d-flex align-items-center cursor-pointer">
            <i class="rck ryd-logout link-primary text-2xl me-4"></i>
            <form id="logout-form-header" action="{{ route('auth-user.logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <span class="link-base text-default fw-bold">Logout</span>
        </a>
    </li>
</ul>