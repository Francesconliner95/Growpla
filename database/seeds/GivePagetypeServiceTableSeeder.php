<?php

use Illuminate\Database\Seeder;
use App\GivePagetypeService;
use Illuminate\Support\Facades\Schema;

class GivePagetypeServiceTableSeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('give_pagetype_services')->truncate();
        Schema::enableForeignKeyConstraints();

        $give_pagetype_services = [
            [
                'service_id'=> 1,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 2,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 3,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 4,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 5,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 6,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 7,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 8,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 9,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 10,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 11,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 12,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 13,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 14,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 15,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 16,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 17,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 18,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 19,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 20,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 21,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 22,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 23,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 24,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 25,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 26,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 27,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 28,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 29,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>30,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>31,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>32,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>33,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>34,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>35,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 36,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=>37,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 38,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 39,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 40,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 41,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 42,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 43,
                'pagetypes_id'=> [2],
            ],
            [
                'service_id'=> 44,
                'pagetypes_id'=> [2],
            ],

        ];

        foreach ($give_pagetype_services as $give_pagetype_service){
            foreach ($give_pagetype_service['pagetypes_id'] as $pagetype_id) {
                $new_give_pagetype_service = new GivePagetypeService();
                $new_give_pagetype_service->service_id = $give_pagetype_service['service_id'];
                $new_give_pagetype_service->pagetype_id = $pagetype_id;
                $new_give_pagetype_service->timestamps = false;
                $new_give_pagetype_service->save();
            }
        }
    }
}
