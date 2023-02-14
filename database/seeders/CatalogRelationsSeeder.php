<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('section_category')->insert([
            ['section_id' => '1','category_id' => '1','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '2','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '3','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '4','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '5','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '6','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '7','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '8','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '9','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '10','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '11','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '12','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '13','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '14','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '15','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '16','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '17','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '18','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '19','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '20','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '21','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '22','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '23','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '24','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '25','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '26','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '27','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '28','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '29','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '30','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '31','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '32','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '33','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '34','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '35','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '36','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '37','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '38','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '39','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '40','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '41','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '42','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '43','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '44','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '45','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '46','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '47','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '48','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '49','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '50','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '51','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '52','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '53','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '54','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '55','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '56','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '57','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '58','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '59','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '60','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '61','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '62','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '63','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '64','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '65','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '66','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '67','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '68','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '69','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '70','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '71','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '72','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '73','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '74','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '75','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '76','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '77','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '78','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '79','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '80','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '81','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '82','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '83','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '84','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '85','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '86','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '87','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '88','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '89','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '90','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '91','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '92','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '93','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '94','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '95','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '96','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '97','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '98','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '99','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '100','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '101','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '102','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '103','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '104','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '105','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '106','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '107','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '108','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '109','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '110','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '111','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '112','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '113','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '114','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '115','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '116','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '117','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '118','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '119','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '120','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '121','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '122','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '123','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '124','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '125','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '126','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '127','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '7','category_id' => '128','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '8','category_id' => '129','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '130','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '131','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '132','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '133','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '134','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '135','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '136','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '137','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '138','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '139','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '140','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '141','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '142','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '143','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '144','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '145','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '1','category_id' => '146','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '2','category_id' => '147','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '4','category_id' => '148','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '149','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '150','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '151','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '152','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '153','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '154','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '11','category_id' => '155','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '13','category_id' => '156','created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['section_id' => '14','category_id' => '157','created_at' => Carbon::now(),'updated_at' => Carbon::now()],

        ]);
    }
}
