<?php

namespace App\Controllers\Service;

use App\Controllers\Service\ApiController;
use App\Models\PayBulan;
use App\Models\PeriodeModel;
use App\Models\Student;
use Exception;

class PayController extends ApiController
{
    public function checkPayMonth()
    {
        $request = $this->request->getVar();

        $pay = new PayBulan();
        $pay = $pay->select('*');

        // mengecek siswa berdasarkan id siswa
        if(isset($request->student_id) && $request->student_id != '') {
            if(is_array($request->student_id) && count($request->student_id) > 0) {
                $pay->whereIn('student_student_id', $request->student_id); // Untuk mengecek lebih dari 1 siswa
            } else {
                $pay->where('student_student_id', $request->student_id); // hanya untuk mengecek satu siswa
            }
        }

        // Mengecek siswa berdasrkan nis
        if(isset($request->student_nis) && $request->student_nis != '') {
            $student = new Student();
            $student = $student->select('student_id');
            if(is_array($request->student_nis) && count($request->student_nis) > 0) {
                $student->whereIn('student_nis', $request->student_nis);
                $student = $student->get()->getResultArray();
                $student = array_column($student, "student_id");
                $pay->whereIn('student_student_id', $student); // Untuk mengecek lebih dari 1 siswa
            } else {
                $student->where('student_nis', $request->student_nis);
                $student = $student->get()->getRowArray();
                $pay->where('student_student_id', $student['student_id']); // hanya untuk mengecek satu siswa
            }
        }

        // mengecek status bulanan lunas atau belum
        if(isset($request->status) && $request->status != '') {
            $pay->where('bulan_status', $request->status);
        }

        // mengecek menampilkan jika yang ditampilkan hanya sudah lunas atau belum
        if(isset($request->is_only_check) && $request->is_only_check == true) {
            $checkPayMonthly = $pay->countAllResults();
            if($checkPayMonthly > 0) {
                return $this->sendRespond(
                    200,
                    'BELUM LUNAS'
                );
            } else {
                return $this->sendRespond(
                    200,
                    'SUDAH LUNAS'
                );
            }
        }

        $checkPayMonthly = $pay->get()->getResult();

        return $this->sendRespond(
            200,
            'DATA SUKSES DITAMPILKAN',
            $checkPayMonthly
        );
    }
}