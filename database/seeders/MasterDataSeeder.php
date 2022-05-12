<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 
        * master data for Admin
        * \Model\Category
        */
        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117001',
				'name' 			=> 'Bencana Alam',
				'description'   => 'Kategori Bencana Alam',
				'icon'	        => '1642387146.svg',
                'sequence'      => '1',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117002',
				'name' 			=> 'Bantuan Medis',
				'description'   => 'Kategori Bantuan Medis',
				'icon'	        => '1642583945.svg',
                'sequence'      => '2',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117003',
				'name' 			=> 'Bantuan Pendidikan',
				'description'   => 'Kategori Bantuan Pendikan',
				'icon'	        => '1642584057.svg',
                'sequence'      => '3',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117004',
				'name' 			=> 'Kegiatan Sosial',
				'description'   => 'Kategori Kegiatan Sosial',
				'icon'	        => '1642584044.svg',
                'sequence'      => '4',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117005',
				'name' 			=> 'Rumah Ibadah',
				'description'   => 'Kategori Rumah Ibadah',
				'icon'	        => '1642584227.svg',
                'sequence'      => '5',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117006',
				'name' 			=> 'Kemanusiaan',
				'description'   => 'Kategori Kemanusiaan',
				'icon'	        => '1642584251.svg',
                'sequence'      => '6',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));


        DB::table('dns_categories')->insert(array(
            array(
				'id'			=> '20220117007',
				'name' 			=> 'Panti Asuhan',
				'description'   => 'Kategori Panti Asuhan',
				'icon'	        => '1642584305.svg',
                'sequence'      => '7',
                'enabled'       => '1',
                'created_by'    => 'Default Sistem',
				'created_at'    => NOW()
            )
        ));

        // Transaction Tipe
        DB::table('sys_transaction_types')->insert(array(
            array(
				'id'			=> 'DONASI',
				'name' 			=> 'Donasi',
				'description'	=> 'Tipe Transaksi Donasi',
				'enabled'	    => '1',
                'created_at'    => NOW()
            )
        ));


		DB::table('sys_transaction_types')->insert(array(
            array(
				'id'			=> 'ZAKAT',
				'name' 			=> 'Zakat',
				'description'	=> 'Tipe Transaksi Zakat',
				'enabled'	    => '1',
                'created_at'    => NOW()
            )
        ));

        // Detail Transaksi Tipe
        DB::table('sys_transaction_details')->insert(array(
            array(
				'id'			      => 'CAMPAIGN',
                'type_transaction_id' => 'DONASI',
				'name' 			      => 'Campaign',
				'description'	      => 'Campaign',
				'enabled'	          => '1',
                'created_at'          => NOW()
                
            )
        ));

        DB::table('sys_transaction_details')->insert(array(
            array(
				'id'			      => 'SEDEKAH_UMUM',
                'type_transaction_id' => 'DONASI',
				'name' 			      => 'Donasi Umum',
				'description'	      => 'Donasi Umum',
				'enabled'	          => '1',
                'created_at'          => NOW()
                
            )
        ));

        DB::table('sys_transaction_details')->insert(array(
            array(
				'id'			      => 'EMAS',
                'type_transaction_id' => 'ZAKAT',
				'name' 			      => 'Zakat Emas',
				'description'	      => 'Zakat Emas',
				'enabled'	          => '1',
                'created_at'          => NOW()
                
            )
        ));

		DB::table('sys_transaction_details')->insert(array(
            array(
				'id'			      => 'MAAL',
                'type_transaction_id' => 'ZAKAT',
				'name' 			      => 'Zakat Maal',
				'description'	      => 'Zakat Maal',
				'enabled'	          => '1',
                'created_at'          => NOW()
                
            )
        ));

		DB::table('sys_transaction_details')->insert(array(
            array(
				'id'			      => 'PROFESI',
                'type_transaction_id' => 'ZAKAT',
				'name' 			      => 'Zakat Profesi',
				'description'	      => 'Zakat Profesi',
				'enabled'	          => '1',
                'created_at'          => NOW()
                
            )
        ));
		

    }
}