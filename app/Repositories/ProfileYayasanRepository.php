<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\ProfileYayasan;
use Illuminate\Http\Request;
use Auth, DB, Cache;

class ProfileYayasanRepository extends Apprepository{
    protected $model;

    public function __construct(ProfileYayasan $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {
        if(!empty($request->file('image_url'))){
			$image = time() . '.' .$request->file('image_url')->getClientOriginalExtension();
		}else if (isset($request['image_url'])){
			$image = $request['image_url'];
		}else {
			$image = null;
        }

        $description = [
            'profile' => $request->input('profile'),
            'misi' => $request->input('misi'),
            'visi' => $request->input('visi'),
            'sejarah' => $request->input('sejarah'),
            'manajemen' => $request->input('manajemen'),
            'legalitas' => $request->input('legalitas'),
            'termcondition' => $request->input('termcondition'),
            'termfundraiser' => $request->input('termfundraiser'),
            'termcorporate' => $request->input('termcorporate'),
            'termpersonal' => $request->input('termpersonal'),
            'termcampaignerpersonal' => $request->input('termcampaignerpersonal'),
            'termcampaignercorporate' => $request->input('termcampaignercorporate'),
            'privacy' => $request->input('privacy')

        ];


        $phone_number = [
            'phone_1' => $request->input('phone_1'),
            'phone_2' => $request->input('phone_2')
        ];

        $social_media = [
            'facebook' => $request->input('facebook'),
            'instagram' => $request->input('instagram'),
            'youtube' => $request->input('youtube'),
        ];

        $website = [
            'website1' => $request->input('website1'),
            'website2' => $request->input('website2')
        ];

        $address = [
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2')
        ];

        $email = [
            'email1' => $request->input('email1'),
            'email2' => $request->input('email2')
        ];

        $jsonDescription = json_encode($description);
        $jsonPhone_number = json_encode($phone_number);
        $jsonSocial_media = json_encode($social_media);
        $jsonWebsite = json_encode($website);
        $jsonAddress = json_encode($address);
        $jsonEmail = json_encode($email);


        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'description' 	=> isset($jsonDescription) ? $jsonDescription : null,
            'image_url' 	=> $image,
            'website' 		=> isset($jsonWebsite) ? $jsonWebsite : null,
            'address'   	=> isset($jsonAddress) ? $jsonAddress : null,
            'email' 		=> isset($jsonEmail) ? $jsonEmail : null,
            'phone_number' 	=> isset($jsonPhone_number) ? $jsonPhone_number : null,
            'social_media' 	=> isset($jsonSocial_media) ? $jsonSocial_media : null,
            'created_by' 	=> Auth::user()->name,
            'updated_by' 	=> Auth::user()->name,
        ];
    }

}
