<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_types')->insert([
            [
                'name' => 'Dinheiro'
            ],
            [
                'name' => 'PIX'
            ],
            [
                'name' => 'Cartão de crédito'
            ],
            [
                'name' => 'Cartão de débito'
            ],
            [
                'name' => 'À prazo'
            ]
        ]);

    }
}
