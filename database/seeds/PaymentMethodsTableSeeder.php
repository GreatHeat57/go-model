<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'paypal',
                'display_name' => 'Paypal',
                'description' => 'Payment with Paypal',
                'has_ccbox' => '0',
                'countries' => NULL,
                'lft' => '0',
                'rgt' => '0',
                'depth' => '1',
                'parent_id' => '0',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'stripe',
                'display_name' => 'Stripe',
                'description' => 'Payment with Stripe',
                'has_ccbox' => '1',
                'countries' => NULL,
                'lft' => '2',
                'rgt' => '2',
                'depth' => '1',
                'parent_id' => '0',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '5',
                'name' => 'offlinepayment',
                'display_name' => 'Offline Payment',
            'description' => 'Offline Payment (Bank Transfer, Check, Cash, etc.)',
                'has_ccbox' => '0',
                'countries' => NULL,
                'lft' => '5',
                'rgt' => '5',
                'depth' => '1',
                'parent_id' => '0',
                'active' => '1',
            ),
        ));
        
        
    }
}