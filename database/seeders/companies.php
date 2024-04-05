<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class companies extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'PT. DOMAS AGROINTI PRIMA',
                'alias' => 'DAP',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'PT. DOMAS SAWIT INTI PERDANA',
                'alias' => 'DSIP',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'PT. BAKRIE FOOD & ENERGY',
                'alias' => 'BFE',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'PT. SARANA INDUSTAMA PERKASA',
                'alias' => 'SIP',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'PT. SAWIT MAS AGRO PERKASA',
                'alias' => 'SMAP',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'PT. FLORA SAWITA CHEMINDO',
                'alias' => 'FSC',
                'created_at' => now(),
                'updated_at' => now(),

            ],

        ]);
    }
}
