<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamilyCompositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('family_compositions')->insert([
            ['id' => 1, 'item_name' => 'Обёртка информационной модели компонента', 'description' => '', 'extension' => 'case', 'template' => '.case', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'item_name' => 'Загружаемое семейство RFA', 'description' => 'Разработанное семейство средствами редактора семейств. В кейсе может быть только один файл семейства.', 'extension' => 'rfa', 'template' => '.rfa', 'required' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'item_name' => 'Revit файл библиотек материалов', 'description' => 'Пользовательские материалы, которые были созданы в ходе разработки семейства', 'extension' => 'adsklib', 'template' => '.adsklib', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'item_name' => 'Изображение семейства', 'description' => 'Изометрический вид или вид в плане, если семейство не имеет 3D геометрию.', 'extension' => 'png', 'template' => '.png', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'item_name' => 'Метаданные кейса', 'description' => 'Идет в качестве "JsonString" при публикации. Информация о семействе для трансляции в интерфейсе пользователя.', 'extension' => 'json', 'template' => '.json', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'item_name' => 'Паспорт изделия/оборудования и т.п.', 'description' => '', 'extension' => 'pdf', 'template' => '.pdf', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'item_name' => 'Таблица типоразмеров', 'description' => '', 'extension' => 'txt', 'template' => '.txt', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'item_name' => 'Таблицы поиска', 'description' => 'LookUpTable', 'extension' => 'csv', 'template' => '.csv', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'item_name' => 'Описание семейства', 'description' => '', 'extension' => 'pdf', 'template' => '_Manual.pdf', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'item_name' => 'Системное семейство', 'description' => 'Настроенное семейство в проекте. В кейсе может быть только один файл семейства.', 'extension' => 'rvt', 'template' => '.rvt', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'item_name' => 'Файл геометрии', 'description' => 'Используется в соответствующих программах для работы с 3D', 'extension' => 'fbx', 'template' => '.fbx', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'item_name' => 'Интероперабельная интерпретация компонента', 'description' => 'Файл, доступный для просмотра в разных ПО для информационного моделирования', 'extension' => 'ifc', 'template' => '.ifc', 'required' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
