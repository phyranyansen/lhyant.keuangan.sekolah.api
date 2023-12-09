<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Student extends Model
{
    protected $DBGroup          = 'default';
    protected $useAutoIncrement = true;
    protected $table            = 'student';
    protected $primaryKey       = 'student_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "student_nis",
        "student_nisn",
        "student_password",
        "student_full_name",
        "student_gender",
        "student_born_place",
        "student_born_date",
        "student_img",
        "student_phone",
        "student_hobby",
        "student_address",
        "student_name_of_mother",
        "student_name_of_father",
        "student_parent_phone",
        "class_class_id",
        "majors_majors_id",
        "student_status",
        "student_last_update",
        "student_input_date"
    ];
}