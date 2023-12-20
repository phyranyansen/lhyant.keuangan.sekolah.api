<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class PeriodeModel extends Model
{

    const ACTIVE = 1;
    const IN_ACTIVE = 0;

    protected $DBGroup          = 'default';
    protected $useAutoIncrement = true;
    protected $table            = 'period';
    protected $primaryKey       = 'period_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
       "period_start",
       "period_end",
       "periode_status"
    ];

    public function checkActivePeriod()
    {
        $period = $this->where('period_status', self::ACTIVE)
            ->first();
        if($period) {
            return $period['period_id'];
        }    
        
        return null;
    }
}