<?php

namespace Modules\DokuMyshortcart\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\DokuMyshortcart\Models\DokuMyshortcartPaymentMethods;
use Modules\Postmetas\Models\Postmetas;

class DokuMyshortcartPaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $contents = [
            [
                'post' => ['author_id' => 1, 'en' => ['title' => 'Alfa Group'], 'id' => ['title' => 'Alfa Group']],
                'postmetas' => [
                    'payment_fee_formula' => '5000',
                    'PAYMENTMETHODID' => '4',
                ],
            ],
            [
                'post' => ['author_id' => 1, 'en' => ['title' => 'ATM Transfer / Bank Transfer'], 'id' => ['title' => 'ATM Transfer / Bank Transfer']],
                'postmetas' => [
                    'payment_fee_formula' => '4500',
                    'PAYMENTMETHODID' => '3',
                ],
            ],
            [
                'post' => ['author_id' => 1, 'en' => ['title' => 'Credit Card - Visa/Mastercard'], 'id' => ['title' => 'Kartu Kredit - Visa/Mastercard']],
                'postmetas' => [
                    'payment_fee_formula' => '(0.03 * total) + 2500',
                    'PAYMENTMETHODID' => '1',
                ],
            ],
            [
                'post' => ['author_id' => 1, 'en' => ['title' => 'Dokuwallet'], 'id' => ['title' => 'Dokuwallet']],
                'postmetas' => [
                    'payment_fee_formula' => '0.02 * total',
                    'PAYMENTMETHODID' => '2',
                ],
            ],
            [
                'post' => ['author_id' => 1, 'en' => ['title' => 'Mandiri Bank Transfer'], 'id' => ['title' => 'Transfer Bank Mandiri']],
                'postmetas' => [
                    'payment_fee_formula' => '5000',
                    'PAYMENTMETHODID' => '10',
                ],
            ],
        ];

        foreach ($contents as $content) {
            $post = DokuMyshortcartPaymentMethods::create($content['post']);
            (new Postmetas)->sync($content['postmetas'], $post->id);
        }
    }
}
