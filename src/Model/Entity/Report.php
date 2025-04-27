<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Report extends Entity
{
    /** @var array<string, bool> */
    protected array $_accessible = [
        'username' => true,
        'report_name' => true,
        'report_xml' => true,
        'upload_timestamp' => true,
    ];
}