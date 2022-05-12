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
  color: #1B3962;
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
  color: #042351;
}

.primary {
  color: #17C68F;
  font-weight: bold;
}

.body-wrapper {
  margin: 24px 0 40px;
}

.text-wrapper .title__ {
  color: #042351;
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
  color: #17C68F;
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
  background-color: #17C68F;
  color: #fff;
  font-size: 16px;
  padding: 16px 45px;
  text-decoration: none;
  font-weight: bold;
  height: 50px;
  line-height: 50px;
  border-radius: 4px;
  box-shadow: 0 3px 6px 0 rgba(4, 35, 81, 0.1);
}

.footer {
  border-top: 1px solid #6A7183;
}
.footer .social {
  padding: 0 6px;
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
  background-color: #17C68F;
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

        <div style="max-width: 680px; margin: auto;" class="email-container">
            <!-- Start Email Body -->
            <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center"
                width="100%" style="
                    max-width: 680px;
                    overflow:hidden;
                    background-color: white;">
                <!-- Start Header -->
                <tr>
                    <td bgcolor="#fff">
                        <img src="{{ asset('frontoffice/assets/img/header.png') }}" width="100%">
                    </td>
                </tr>
                <!-- End Header -->
                <!-- Start Isi -->
                <tr>
                    <td bgcolor="#ffffff">
                        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"
                            width="100%">
                            <tr>
                                <td style="padding:0 24px; font-size: 16px; line-height: 26px; color: #555555;">

                                    <div class="body-wrapper">

                                        <div class="text-wrapper">
                                            <div class="title__">
                                                Perubahan Kata Sandi
                                            </div>

                                            <div class="group">
                                              <p>
                                                  Assalamu'alaikum Warohmatullahi Wabarokaatuh {{ ($token->name) ? $token->name : $token->email }},
                                                  <br><br>
                                                  Anda akan mengubah kata sandi <br><br>
                                                  Kode OTP Kakak adalah:
                                              </p>
                                              <h3><b> {{ ($token->hasUserEmail->otp) ?? $token->hasUserPhone->otp }} </b></h3>
                                          </div>
                                          <div class="group">
                                              <p>
                                                  Catatan:
                                              </p>
                                              <div class="small">
                                                  Jangan beritahu OTP ini ke siapapun, segala tindak kejahatan bukan tanggung jawab kami, Terimakasih
                                              </div>
                                          </div>

                                            <div class="group">
                                                <p>
                                                    Jika Anda tidak melakukannya, silahkan abaikan email ini atau hubungi customer service kami.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- End Isi -->
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
            </table>
            <!-- End Email Body-->
        </div>
    </center>
</body>

</html>