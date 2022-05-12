<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;

class ProfileCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//Menu
		DB::table('sys_profile_instations')->insert(array(
            array(
				'id'			=> '2020151001001',
				'name' 			=> 'Diginusa Studio',
                'description'	=> '{"profile":"Lorem Ipsum","visimisi":"Lorem Ipsum","sejarah":"Lorem Ipsum","manajemen":"Lorem Ipsum","legalitas":"Lorem Ipsum","termcondition":"Lorem Ipsum","termfundraiser":"Lorem Ipsum","termcampaignerpersonal":"Lorem Ipsum","termcampaignercorporate":"Lorem Ipsum","privacy":"Lorem Ipsum"}',
				'website'		=> '{"website1":"Jl. Cibiru Bandung","website2":"-"}',
				'address'		=> '{"address1":"Lorem Ipsum","address2":"-"}',
				'email'			=> '{"email1":"loremipsum@mail.com","email2":"-"}',
                'phone_number'	=> '{"phone_1":"089526512214","phone_2":"-"}',
				'social_media'	=> '{"facebook":"diginusastudio","instagram":"diginusastudio","youtube":"-"}',
            )
        ));

    }
}
