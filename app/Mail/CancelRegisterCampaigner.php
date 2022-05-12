<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ProfileYayasan;

class CancelRegisterCampaigner extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $comment, $note)
    {
        $this->data = $data;
        $this->comment = $comment;
        $this->note = $note;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $profile = ProfileYayasan::find('2020151001001');

        $phone_number = json_decode($profile->phone_number);
        $email = json_decode($profile->email);
        $social_media = json_decode($profile->social_media);

        $phone_number = [
            'phone' => ($phone_number->phone_1) ?? '-',
        ];

        $email = [
            'email' => ($email->email1) ?? '-',
        ];

        $social_media = [
            'facebook' => ($social_media->facebook) ?? '-',
            'instagram' => ($social_media->instagram) ?? '-',
            'youtube' => ($social_media->youtube) ?? '-',
        ];

        return $this->view('frontoffice.email.cancel_register-campaigner', compact('phone_number', 'email', 'social_media'))
            ->subject('Gagal Daftar Campaigner')
            ->with([
                'data' => $this->data,
                'comment' => $this->comment,
                'note' => $this->note,
            ]);
    }
}