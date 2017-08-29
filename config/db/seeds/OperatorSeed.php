<?php

use Phinx\Seed\AbstractSeed;

class OperatorSeed extends AbstractSeed
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
                'name' => 'Operator 1'
            ],
            [
                'name' => 'Operator 2'
            ]
        ];

        $posts = $this->table('operator');
        $posts->insert($data)
              ->save();
    }
}
