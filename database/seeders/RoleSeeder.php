<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		DB::table('roles')->insert(array(
            array(
				'id'			=> '2020151101001',
				'name' 			=> 'Super Admin',
				'enabled'		=> 1,
				'guard_name'	=> 'web',
            )
        ));

        DB::table('roles')->insert(array(
            array(
				'id'			=> '2020151101002',
				'name' 			=> 'Admin',
				'enabled'		=> 1,
				'guard_name'	=> 'web',
            )
        ));

        //Model Has Role
        DB::table('model_has_roles')->insert(array(
            array(
                'role_id' 		=> '2020151101001',
                'model_type'	=> 'App\Models\User',
                'model_id'		=> '2020151101001',
            )
        ));
        
		//Role Has Permission
        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101001',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101002',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101003',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101004',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101005',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101006',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101007',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101008',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101009',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101010',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101011',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101012',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101013',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101014',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101015',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101016',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101017',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101018',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101019',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101020',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101021',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101022',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101023',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101024',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101025',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101026',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101027',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101028',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101029',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101030',
				'role_id' 			=> '2020151101001',
            )
        ));
        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101031',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101032',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101033',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101034',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101035',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101036',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101037',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101038',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101039',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101040',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101041',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101042',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101043',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101044',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101045',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101046',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101047',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101048',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101049',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101050',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101051',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101052',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101053',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101054',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101055',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101056',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101057',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101058',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101059',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101060',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101061',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101062',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101063',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101064',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101065',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101066',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101067',
				'role_id' 			=> '2020151101001',
            )
        ));

        DB::table('role_has_permissions')->insert(array(
            array(
				'permission_id'		=> '2020151101068',
				'role_id' 			=> '2020151101001',
            )
        ));

    }
}
