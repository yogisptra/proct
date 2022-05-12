<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <style>html {
  font-family: sans-serif;
  color: #777783;
  font-weight: 300;
  font-size: 16px;
  background-color: #f4f4f4;
}

.email-container {
  padding: 50px 0;
}

@media screen and (max-width: 680px) {
  .email-container {
    padding: 0;
  }
}
b, strong {
  color: #3d3d4e;
}

.primary {
  color: #F23434;
  font-weight: bold;
}

.header td {
  border-bottom: 1px solid rgba(158, 158, 167, 0.15);
}

.body-wrapper {
  margin: 32px 0 40px;
}

.text-wrapper .title__ {
  color: #3d3d4e;
  margin-bottom: 16px;
  font-size: 24px;
  font-weight: bold;
}
.text-wrapper p {
  font-size: 16px;
  margin: 0;
}
.text-wrapper a {
  font-weight: bold;
  color: #F23434;
  text-decoration: unset;
}
.text-wrapper .group {
  margin-bottom: 24px;
}

.btn-wrapper {
  text-align: center;
}
.btn-wrapper .primary-btn {
  text-transform: uppercase;
  background-color: #F23434;
  color: #fff;
  font-size: 16px;
  padding: 16px 45px;
  text-decoration: none;
  font-weight: bold;
  height: 50px;
  line-height: 50px;
  border-radius: 4px;
  box-shadow: 0 3px 6px 0 rgba(61, 61, 78, 0.1);
}

.footer {
  background-color: transparent;
  border-top: 1px solid rgba(158, 158, 167, 0.15);
  color: #777783;
}
.footer b, .footer strong {
  color: #777783;
}
.footer .social {
  padding: 0 6px;
}
.footer .social img {
  border-radius: 50%;
}
.footer a {
  display: inline-block;
  text-decoration: none;
}
.footer a img {
  width: 32px;
  height: 32px;
}
.footer a:hover {
  text-decoration: none;
}
.footer p {
  padding-bottom: 8px;
}

.footer-cp {
  padding: 16px;
  text-align: center;
  background-color: #3d3d4e;
  display: block;
  color: white;
  font-size: 12px;
}

.error {
  font-weight: bold;
  color: #FF3C5A;
}
/*# sourceMappingURL=styles.css.map */

    </style>
  </head>
  <body width="100%" bgcolor="#FAFAFA" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background: #ECEBED; text-align: left;">
      <div class="email-container" style="max-width: 680px; margin: auto;">
        <!-- Start Email Body-->
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="        max-width: 680px;        overflow:hidden;        background-color: white;">
          <!-- Start Header-->
          <tbody>
            <tr class="header">
              <td bgcolor="#fff"><img src="{{ asset('frontoffice/assets/img/header.png') }}" width="100%"></td>
            </tr>
            <!-- End Header-->
            <tr>
              <td bgcolor="#ffffff">
                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="padding:0 24px; font-size: 16px; line-height: 26px; color: #555555;">
                        <div class="body-wrapper">
                          <div class="text-wrapper">
                            <div class="title__">Komitmen Sedekah</div>
                            <div class="group">
                              <p>Assalamu'alaikum Warohmatullahi Wabarokaatuh {{ $data->name }},<br><br>
                                Kami telah menerima komitmen anda pada program <b>{{ ($data->hasCampaign->title) ?? $data->type_transaction_id }}</b> sebesar:</p>
                              <p class="primary">Rp{{number_format($data['amount']+$data['unique_code'],0,'.','.')}},-</p>
                              <p>pada hari {{ Carbon\Carbon::parse($data->transaction_date)->translatedFormat('l') }}, <b>{{ Carbon\Carbon::parse($data->transaction_date)->translatedFormat('d F Y') }}</b><br>
                                dengan nomor transaksi <b>{{ $data->transaction_number }}</b></p>
                            </div>
                            <div class="group">
                              <p>Silahkan transfer ke rekening 
                                  <b>{{ $data->hasBankAccount->hasBank->name }}</b> 
                                  berikut:<br><b>{{ $data->hasBankAccount->hasBank->name }}</b><br>No Rek. <b>{{ $data->hasBankAccount->account_number }}</b><br>                                                    
                                  a.n <b>{{ $data->hasBankAccount->account_name }}</b></p>
                            </div>
                            <div class="group">
                              <p>Catatan:<br>Pastikan anda memasukan kode unik <strong>{{ $data->unique_code }}</strong> di nominal transfer.
                                <br>Perbedaan nilai transfer akan menghambat proses verifikasi Transaksi Anda.
                              </p>
                            </div>
                            <div class="group">
                              <p>Jika anda telah melakukan pembayaran ke nomor rekening Donasi.Co, silahkan melakukan Konfirmasi Manual dengan klik tautan
                                dibawah ini:
                              </p><a href="{{ route('dashboard-confirmation_manualTransaction', $data->transaction_number) }}" target="_blank">https://donasi.co/konfirmasi-pembayaran</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
                <td align="center" valign="middle" style="
                    height: 160px;
                    " class="footer">

                    <div>
                        <p>Call Center : {{ $phone_number['phone'] }}</p>
                        <p>Email : {{ $email['email'] }}</p>
                    </div>

                    <a class="social" href="{{ $social_media['facebook'] }}">
                    <img src="{{ asset('frontoffice/assets/img/facebook.png') }}">
                    </a>
                    <a class="social" href="{{ $social_media['instagram'] }}">
                        <img src="{{ asset('frontoffice/assets/img/instagram.png') }}">
                    </a>
                    <a class="social" href="{{ $social_media['youtube'] }}">
                        <img src="{{ asset('frontoffice/assets/img/youtube.png') }}">
                    </a>
                </td>
            </tr>
            <tr>
              <td>
                <div class="footer-cp">Copyright ©2022 Donasi.Co</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </center>
  </body>
</html>