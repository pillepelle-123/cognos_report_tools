<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReportsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reports');
        $this->setDisplayField('report_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('report_name')
            ->maxLength('report_name', 255)
            ->requirePresence('report_name', 'create')
            ->notEmptyString('report_name');

        $validator
            ->scalar('report_xml')
            ->requirePresence('report_xml', 'create')
            ->notEmptyString('report_xml');
        
        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->requirePresence('username', 'create')
            ->notEmptyString('username');

        return $validator;
    }
}