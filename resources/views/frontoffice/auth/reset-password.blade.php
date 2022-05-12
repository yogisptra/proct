@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            <h1 class="h4 mb-4">Reset Kata Sandi</h1>
            <p class="text-default mt-4">Buat kata sandi yang mudah diingat ya sahabat donasi.</p>
            <form class="mt-6" action="{{ route('auth-user.updatePassword') }}" method="post">
                {{ csrf_field() }}
                @method('PUT')
                <input class="input" type="email" name="email" value="{{ $data->email }}">
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock {{ $errors->has('password') ? 'text-danger' : 'text-primary' }}"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                        <input class="input px-12" name="password" value="{{ old('password') }}" type="password" placeholder="Buat Kata Sandi">
                    </div>
                    @if ($errors->has('password'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('password') }}</span>  
                    @endif
                </div>
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock {{ $errors->has('confirm_password') ? 'text-danger' : 'text-primary' }}"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                        <input class="input px-12"  name="confirm_password" value="{{ old('confirm_password') }}"  type="password" placeholder="Ulangi Kata Sandi">
                    </div>
                    @if ($errors->has('confirm_password'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('confirm_password') }}</span>  
                    @endif
                </div>
                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Simpan">
            </form>
        </div>
    </section>
</main>
@endsection

@section('bottom-resource')
<script src="{{ asset('frontoffice/assets/js/otp-input.js') }}"></script>
@endsection