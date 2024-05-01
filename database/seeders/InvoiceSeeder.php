<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <=10 ; $i++) {
            Invoice::create([
               'user_id'=>5,
                'training_id'=>13,
                'order_number'=>115,
                'status'=>'pending',
                'amount'=>10,
                'user_type'=>'online'
            ]);
        }
    }
}
