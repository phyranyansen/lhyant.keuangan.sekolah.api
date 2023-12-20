<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class PayBulan extends Model
{
    protected $DBGroup          = 'default';
    protected $useAutoIncrement = true;
    protected $table            = 'bulan';
    protected $primaryKey       = 'bulan_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "student_student_id",
        "payment_payment_id",
        "month_month_id",
        "bulan_bill",
        "bulan_status",
        "bulan_number_pay",
        "bulan_date_pay",
        "user_user_id",
        "bulan_input_date",
        "bulan_last_update",
        "bulan_additional_bill",
        "bulan_pay"
    ];
}