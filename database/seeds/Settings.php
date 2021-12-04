<?php

namespace Database\Seeds;

use App\Models\Model;
use Illuminate\Database\Seeder;
use Setting;

class Settings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (setting('barcode') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'barcode',
                    'value' => '{ISBN}-{INCREMENT}'
                ]
            );
        }

        if (setting('currency') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'currency',
                    'value' => 'EUR'
                ]
            );
        }

        if (setting('member_code_prefix') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'member_code_prefix',
                    'value' => ''
                ]
            );
        }

        if (setting('member_code_prefix') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'take_in_status',
                    'value' => 'available'
                ]
            );
        }

        if (setting('short_cut_take_in') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'short_cut_take_in',
                    'value' => 'i'
                ]
            );
        }

        if (setting('short_cut_lend') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'short_cut_lend',
                    'value' => 'l'
                ]
            );
        }

        if (setting('short_cut_pay') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'short_cut_pay',
                    'value' => 'p'
                ]
            );
        }

        if (setting('reservation_costs') === null) {
            \DB::table('settings')->insert(
                [
                    'key' => 'reservation_costs',
                    'value' => '0'
                ]
            );
        }

        Model::reguard();
    }
}
