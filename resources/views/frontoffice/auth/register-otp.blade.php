@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            <h1 class="h4 mb-4">Verifikasi</h1>
            <p class="text-default mt-4">Masukan kode verifikasi akun yang telah kami kirim ke email/nomor telepon.
                {{-- <strong id="maskEmail"></strong> --}}
            </p>
            <input type="text" hidden value="{{ $data->email }}" id="valEmail">
            <form class="mt-6" action="{{ route('auth-user.confirmationPin', $data->id) }}" method="POST">
                @csrf
                <div class="row gx-4" id="otp">
                     <input class="otp-input text-center w-full {{ $errors->has('otp') ? 'text-danger' : 'text-primary' }}" type="text" name="otp" data-inputmask="'mask': '999999'" inputmode="numeric">
                </div>
                @if(Session::has('error'))
                <span class="text-danger text-center d-block text-xs mt-4">Kode OTP tidak sesuai.</span>
                @endif
                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Kirim">
            </form>
            <div class="flex-col mt-6 text-center timers">Waktu tunggu email <span id="time">00:30</span> detik</div>
            <div class="mt-6 text-center sendEmail">
                <a class="link-primary" href="{{ route('auth-user.sendEmail', $data->id) }}">Kirim Ulang Kode</a>
            </div>
        </div>
    </section>
</main>

@endsection

@section('bottom-resource')
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<script>
    $(":input").inputmask();
    
    let myemailId = $('#valEmail').val();
    var maskid = myemailId.replace(/^(.)(.*)(.@.*)$/,
            (_, a, b, c) => a + b.replace(/./g, '*') + c
    );
    
    $('#maskEmail').html(maskid)
    
    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        var myInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
    
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
    
            display.textContent = minutes + ":" + seconds;
            
            if (--timer < 0) {
                $(".timers").hide();
                $(".sendEmail").show();
                clearInterval(myInterval);
            }
        }, 1000);
    }
    
    window.onload = function () {
        var fiveMinutes = 30,
            display = document.querySelector('#time');
            $(".sendEmail").hide();
            startTimer(fiveMinutes, display);
            
    };
</script>
@endsection