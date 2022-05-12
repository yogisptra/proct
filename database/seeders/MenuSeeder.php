<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//Menu
		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001001',
				'name' 			=> 'Dashboard',
				'description'	=> 'Dashboard',
				'route'			=> 'home',
				'sequence'		=> 1,
				'icon'			=> 'fa fa-home',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001003',
				'name' 			=> 'Management Data',
				'description'	=> 'Management Data',
				'sequence'		=> 2,
				'icon'			=> 'fa fa-folder',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001004',
                'parent_id'     => '2020151001003',
                'name'          => 'Data Rekening',
                'description'   => 'Data Rekening',
                'sequence'      => 1,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'without-authorize',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001005',
                'parent_id'     => '2020151001004',
                'name'          => 'Data Bank Kategori',
                'description'   => 'Data Bank Kategori',
                'route'         => 'banks.index',
                'sequence'      => 1,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-bank-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001006',
                'parent_id'     => '2020151001004',
                'name'          => 'Data Akun Bank',
                'description'   => 'Data Akun Bank',
                'route'         => 'bank_accounts.index',
                'sequence'      => 2,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-bank_account-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001007',
                'parent_id'     => '2020151001003',
                'name'          => 'Data Kategori',
                'description'   => 'Data Kategori',
                'route'         => 'categories.index',
                'sequence'      => 3,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-category-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001008',
                'parent_id'     => '2020151001003',
                'name'          => 'Data Banner Slider',
                'description'   => 'Data Banner Slider',
                'route'         => 'sliders.index',
                'sequence'      => 4,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-slider-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001009',
                'parent_id'     => '2020151001003',
                'name'          => 'Data FAQ',
                'description'   => 'Data FAQ',
                'sequence'      => 5,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'without-authorize',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001011',
                'parent_id'     => '2020151001009',
                'name'          => 'Data FAQ Kategori',
                'description'   => 'Data FAQ Kategori',
                'route'         => 'faq_categories.index',
                'sequence'      => 1,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-faq_category-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001012',
                'parent_id'     => '2020151001009',
                'name'          => 'Data FAQ Deskripsi',
                'description'   => 'Data FAQ Deskripsi',
                'route'         => 'faq_descriptions.index',
                'sequence'      => 2,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-faq_description-list',
                'created_at'    => NOW()
            )
        ));
		
        DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001014',
				'name' 			=> 'Approval',
				'description'	=> 'Approval',
				'sequence'		=> 3,
				'icon'			=> 'fa fa-handshake',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001015',
				'parent_id'		=> '2020151001014',
				'name' 			=> 'Data Approval Campaigner',
				'description'	=> 'Data Approval Campaigner',
				'route'			=> 'campaigner-approval.index',
				'sequence'		=> 1,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'approval-campaigner-list',
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001016',
				'parent_id'		=> '2020151001014',
				'name' 			=> 'Data Approval Transaksi',
				'description'	=> 'Data Approval Transaksi',
				'route'			=> 'transaction-approval.index',
				'sequence'		=> 2,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'approval-transaction-list',
            )
        ));


		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001017',
				'name' 			=> 'Pengaturan',
				'description'	=> 'Pengaturan',
				'sequence'		=> 5,
				'icon'			=> 'fa fa-cog',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001018',
				'parent_id'		=> '2020151001017',
				'name' 			=> 'Data User',
				'description'	=> 'Data User',
				'route'			=> 'users.index',
				'sequence'		=> 1,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001019',
				'parent_id'		=> '2020151001017',
				'name' 			=> 'Data Role',
				'description'	=> 'Data Role',
				'route'			=> 'roles.index',
				'sequence'		=> 2,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'role-list',
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001020',
				'parent_id'		=> '2020151001017',
				'name' 			=> 'Data Menu',
				'description'	=> 'Data Menu',
				'route'			=> 'menus.index',
				'sequence'		=> 3,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'menu-list',
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001021',
				'parent_id'		=> '2020151001017',
				'name' 			=> 'Profile Donasi.co',
				'description'	=> 'Profile Donasi.co',
				'route'			=> 'profile-yayasan.index',
				'sequence'		=> 4,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

        // Tipe Transaksi
        DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001022',
                'parent_id'     => '2020151001003',
                'name'          => 'Data Tipe Transaksi',
                'description'   => 'Data Tipe Transaksi',
                'sequence'      => 6,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'without-authorize',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001023',
                'parent_id'     => '2020151001022',
                'name'          => 'Data Transaksi Tipe',
                'description'   => 'Data Transaksi Tipe',
                'route'         => 'transaction_types.index',
                'sequence'      => 1,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-transaksi-tipe-list',
                'created_at'    => NOW()
            )
        ));

		DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001024',
                'parent_id'     => '2020151001022',
                'name'          => 'Data Transaksi Detail',
                'description'   => 'Data Transaksi Detail',
                'route'         => 'transaction_detail.index',
                'sequence'      => 2,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-transaksi-detail-list',
                'created_at'    => NOW()
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001025',
				'name' 			=> 'Laporan',
				'description'	=> 'Laporan',
				'sequence'		=> 4,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'without-authorize',
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001026',
                'parent_id'     => '2020151001025',
                'name'          => 'Laporan Campaign',
                'description'   => 'Laporan Campaign',
                'route'         => 'laporan-campaign.index',
                'sequence'      => 1,
                'icon'          => 'fa fa-book',
                'enabled'       => 1,
                'shown'         => 'laporan-campaign-list',
                'created_at'    => NOW()
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001027',
                'parent_id'     => '2020151001025',
                'name'          => 'Laporan Transaksi',
                'description'   => 'Laporan Transaksi',
                'route'         => 'laporan-transaction.index',
                'sequence'      => 2,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'laporan-transaksi-list',
                'created_at'    => NOW()
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
				'id'			=> '2020151001028',
				'parent_id'		=> '2020151001014',
				'name' 			=> 'Data Approval Pencairan',
				'description'	=> 'Data Approval Pencairan',
				'route'			=> 'widhdrawal-approval.index',
				'sequence'		=> 3,
				'icon'			=> '-',
				'enabled'		=> 1,
				'shown'			=> 'approval-widhdrawal-list',
            )
        ));

        DB::table('sys_menus')->insert(array(
            array(
                'id'            => '2020151001029',
                'parent_id'     => '2020151001003',
                'name'          => 'Data Tipe Lembaga',
                'description'   => 'Data Tipe Lembaga',
                'route'         => 'type_corporates.index',
                'sequence'      => 6,
                'icon'          => '-',
                'enabled'       => 1,
                'shown'         => 'data-type_corporate-list',
                'created_at'    => NOW()
            )
        ));

    }
}