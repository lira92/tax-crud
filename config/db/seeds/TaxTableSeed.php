<?php

use Phinx\Seed\AbstractSeed;

class TaxTableSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'description' => 'Tax table 2017',
                'effective_date' => date('Y-m-d H:i:s'),
                'operator_id' => 1
            ],
            [
                'description' => 'Tax Table 2019',
                'effective_date' => date('2019-m-d H:i:s'),
                'operator_id' => 2
            ]
        ];

        $tax_table = $this->table('tax_table');
        $tax_table->insert($data)
              ->save();

        $tax_data = [
            [
                'tax_table_id' => 1,
                'value' => 10,
                'from_value' => 500,
                'until_value' => 1000
            ],
            [
                'tax_table_id' => 1,
                'value' => 5,
                'from_value' => 1001,
                'until_value' => 5000
            ],
            [
                'tax_table_id' => 2,
                'value' => 11,
                'from_value' => 500,
                'until_value' => 1000
            ],
            [
                'tax_table_id' => 2,
                'value' => 6,
                'from_value' => 1001,
                'until_value' => 5000
            ]
        ];

        $tax = $this->table('tax');
        $tax->insert($tax_data)
              ->save();
    }
}
