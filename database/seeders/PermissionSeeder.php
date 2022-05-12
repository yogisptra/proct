<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 
        * Permission master data for Admin
        * \Model\Role
        */
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101001',
				'name' 			=> 'role-list',
				'type'			=> 'Role',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101002',
				'name' 			=> 'role-create',
				'type'			=> 'Role',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101003',
				'name' 			=> 'role-edit',
				'type'			=> 'Role',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101004',
				'name' 			=> 'role-delete',
				'type'			=> 'Role',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		//menu
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101005',
				'name' 			=> 'menu-list',
				'type'			=> 'Menu',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101006',
				'name' 			=> 'menu-create',
				'type'			=> 'Menu',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101007',
				'name' 			=> 'menu-edit',
				'type'			=> 'Menu',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101008',
				'name' 			=> 'menu-delete',
				'type'			=> 'Menu',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        //user
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101009',
				'name' 			=> 'user-list',
				'type'			=> 'User',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101010',
				'name' 			=> 'user-create',
				'type'			=> 'User',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101011',
				'name' 			=> 'user-edit',
				'type'			=> 'User',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101012',
				'name' 			=> 'user-delete',
				'type'			=> 'User',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Bank
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101013',
				'name' 			=> 'data-bank-list',
				'type'			=> 'Bank',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101014',
				'name' 			=> 'data-bank-create',
				'type'			=> 'Bank',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101015',
				'name' 			=> 'data-bank-edit',
				'type'			=> 'Bank',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101016',
				'name' 			=> 'data-bank-delete',
				'type'			=> 'Bank',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Bank Akun
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101017',
				'name' 			=> 'data-bank_account-list',
				'type'			=> 'Bank Akun',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101018',
				'name' 			=> 'data-bank_account-create',
				'type'			=> 'Bank Akun',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101019',
				'name' 			=> 'data-bank_account-edit',
				'type'			=> 'Bank Akun',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101020',
				'name' 			=> 'data-bank_account-delete',
				'type'			=> 'Bank Akun',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Kategori
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101021',
				'name' 			=> 'data-category-list',
				'type'			=> 'Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101022',
				'name' 			=> 'data-category-create',
				'type'			=> 'Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101023',
				'name' 			=> 'data-category-edit',
				'type'			=> 'Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101024',
				'name' 			=> 'data-category-delete',
				'type'			=> 'Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Slider Banner
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101025',
				'name' 			=> 'data-slider-list',
				'type'			=> 'Slider',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101026',
				'name' 			=> 'data-slider-create',
				'type'			=> 'Slider',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101027',
				'name' 			=> 'data-slider-edit',
				'type'			=> 'Slider',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101028',
				'name' 			=> 'data-slider-delete',
				'type'			=> 'Slider',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// FAQ Kategori
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101029',
				'name' 			=> 'data-faq_category-list',
				'type'			=> 'FAQ Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101030',
				'name' 			=> 'data-faq_category-create',
				'type'			=> 'FAQ Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101031',
				'name' 			=> 'data-faq_category-edit',
				'type'			=> 'FAQ Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101032',
				'name' 			=> 'data-faq_category-delete',
				'type'			=> 'FAQ Kategori',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// FAQ Deskripsi
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101033',
				'name' 			=> 'data-faq_description-list',
				'type'			=> 'FAQ Deskripsi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101034',
				'name' 			=> 'data-faq_description-create',
				'type'			=> 'FAQ Deskripsi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101035',
				'name' 			=> 'data-faq_description-edit',
				'type'			=> 'FAQ Deskripsi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101036',
				'name' 			=> 'data-faq_description-delete',
				'type'			=> 'FAQ Deskripsi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Approval Campaigner
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101037',
				'name' 			=> 'approval-campaigner-list',
				'type'			=> 'Approval Campaigner',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101038',
				'name' 			=> 'approval-campaigner-create',
				'type'			=> 'Approval Campaigner',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101039',
				'name' 			=> 'approval-campaigner-edit',
				'type'			=> 'Approval Campaigner',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101040',
				'name' 			=> 'approval-campaigner-delete',
				'type'			=> 'Approval Campaigner',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Laporan Campaign
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101041',
				'name' 			=> 'laporan-campaign-list',
				'type'			=> 'Laporan Campaign',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101042',
				'name' 			=> 'laporan-campaign-create',
				'type'			=> 'Laporan Campaign',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101043',
				'name' 			=> 'laporan-campaign-edit',
				'type'			=> 'Laporan Campaign',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101044',
				'name' 			=> 'laporan-campaign-delete',
				'type'			=> 'Laporan Campaign',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Transaksi Tipe
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101045',
				'name' 			=> 'data-transaksi-tipe-list',
				'type'			=> 'Tipe Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101046',
				'name' 			=> 'data-transaksi-tipe-create',
				'type'			=> 'Tipe Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101047',
				'name' 			=> 'data-transaksi-tipe-edit',
				'type'			=> 'Tipe Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101048',
				'name' 			=> 'data-transaksi-tipe-delete',
				'type'			=> 'Tipe Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Transaksi Detail
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101049',
				'name' 			=> 'data-transaksi-detail-list',
				'type'			=> 'Tipe Transaksi Detail',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101050',
				'name' 			=> 'data-transaksi-detail-create',
				'type'			=> 'Tipe Transaksi Detail',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101051',
				'name' 			=> 'data-transaksi-detail-edit',
				'type'			=> 'Tipe Transaksi Detail',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101052',
				'name' 			=> 'data-transaksi-detail-delete',
				'type'			=> 'Tipe Transaksi Detail',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Approval Transaksi
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101053',
				'name' 			=> 'approval-transaction-list',
				'type'			=> 'Approval Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101054',
				'name' 			=> 'approval-transaction-create',
				'type'			=> 'Approval Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101055',
				'name' 			=> 'approval-transaction-edit',
				'type'			=> 'Approval Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101056',
				'name' 			=> 'approval-transaction-delete',
				'type'			=> 'Approval Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101057',
				'name' 			=> 'laporan-transaksi-list',
				'type'			=> 'Laporan Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101058',
				'name' 			=> 'laporan-transaksi-create',
				'type'			=> 'Laporan Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101059',
				'name' 			=> 'laporan-transaksi-edit',
				'type'			=> 'Laporan Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101060',
				'name' 			=> 'laporan-transaksi-delete',
				'type'			=> 'Laporan Transaksi',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Approval Pencairan
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101061',
				'name' 			=> 'approval-widhdrawal-list',
				'type'			=> 'Approval Widhdrawal',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101062',
				'name' 			=> 'approval-widhdrawal-create',
				'type'			=> 'Approval Widhdrawal',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101063',
				'name' 			=> 'approval-widhdrawal-edit',
				'type'			=> 'Approval Widhdrawal',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101064',
				'name' 			=> 'approval-widhdrawal-delete',
				'type'			=> 'Approval Widhdrawal',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

		// Master Data Tipe Lembaga
		DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101065',
				'name' 			=> 'data-type_corporate-list',
				'type'			=> 'Tipe Lembaga',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101066',
				'name' 			=> 'data-type_corporate-create',
				'type'			=> 'Tipe Lembaga',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101067',
				'name' 			=> 'data-type_corporate-edit',
				'type'			=> 'Tipe Lembaga',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

        DB::table('permissions')->insert(array(
            array(
				'id'			=> '2020151101068',
				'name' 			=> 'data-type_corporate-delete',
				'type'			=> 'Tipe Lembaga',
				'guard_name'	=> 'web',
				'created_at'    => NOW()
            )
        ));

    }
}