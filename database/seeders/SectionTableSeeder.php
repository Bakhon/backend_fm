<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
                [
                    'id' => 1,
                    'name' => 'Архитектурные решения',
                    'short_name' => 'АР',
                    'order' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 2,
                    'name' => 'Архитектурно-строительные решения',
                    'short_name' => 'АС',
                    'order' => 3,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 3,
                    'name' => 'Фасады',
                    'short_name' => 'ФС',
                    'order' => 4,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 4,
                    'name' => 'Конструкции железобетонные',
                    'short_name' => 'КЖ',
                    'order' => 5,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 5,
                    'name' => 'Конструкции железобетонные изделия',
                    'short_name' => 'КЖИ',
                    'order' => 6,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 6,
                    'name' => 'Конструкции металические',
                    'short_name' => 'КМ',
                    'order' => 7,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 7,
                    'name' => 'Отопление и вентиляция',
                    'short_name' => 'ОВ',
                    'order' => 8,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 8,
                    'name' => 'Водоснабжение и канализация',
                    'short_name' => 'ВК',
                    'order' => 9,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 9,
                    'name' => 'Автоматическое пожаротушение',
                    'short_name' => 'АП',
                    'order' => 10,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 10,
                    'name' => 'Газоснабжение',
                    'short_name' => 'ГС',
                    'order' => 11,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 11,
                    'name' => 'Электрооборудование и освещение',
                    'short_name' => 'ЭОМ',
                    'order' => 12,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 12,
                    'name' => 'Освещение фасадов',
                    'short_name' => 'ФСО',
                    'order' => 13,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 13,
                    'name' => 'Пожарная сигнализация',
                    'short_name' => 'ПС',
                    'order' => 14,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'id' => 14,
                    'name' => 'Системы связи',
                    'short_name' => 'СС',
                    'order' => 15,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]
        );
    }
}
