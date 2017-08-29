<?php

use Phinx\Migration\AbstractMigration;

class CreateTaxTable extends AbstractMigration
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
        $taxTable = $this->table('tax_table');
        $taxTable->addColumn('description', 'text')
                 ->addColumn('effective_date', 'datetime')
                 ->addColumn('operator_id', 'integer')
                 ->addForeignKey('operator_id', 'operator', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
                 ->save();
    }
}
