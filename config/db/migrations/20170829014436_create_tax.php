<?php

use Phinx\Migration\AbstractMigration;

class CreateTax extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $tax = $this->table('tax');
        $tax->addColumn('value', 'float')
            ->addColumn('from_value', 'float')
            ->addColumn('until_value', 'float')
            ->addColumn('tax_table_id', 'integer')
            ->addForeignKey('tax_table_id', 'tax_table', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->save();
    }
}
