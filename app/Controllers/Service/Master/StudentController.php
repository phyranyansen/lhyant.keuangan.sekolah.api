<?php

namespace App\Controllers\Service\Master;

use App\Controllers\Service\ApiController;
use App\Controllers\BaseController;
use App\Models\Student;
use Exception;

class StudentController extends ApiController
{
    public function getStudent()
    {
        $post = $this->request->getVar();
        $student = new Student();
        $data = $student->select('*');
        if(isset($post->student_id)) {
            $data = $student->where('student_id', $post->student_id);
        }

        $data = $data->get()->getResult();

        if($data) {
            return $this->sendRespond(
                200,
                'Data student ditemukan.',
                $data
            );
        }

        return $this->sendRespond(
            400,
            'Data tidak ditemukan.'
        );
    }

    public function addStudent()
    {
        $post = $this->request->getVar();

        $messageError = [];
        if(!isset($post->student_nis) || $post->student_nis == '') {
            $messageError[] = 'Harap mengisi nis siswa';
        }

        if(!isset($post->student_nisn) || $post->student_nisn == '') {
            $messageError[] = 'Harap mengisi nisn siswa';
        }

        if(!isset($post->student_full_name) || $post->student_full_name == '') {
            $messageError[] = 'Harap mengisi nama siswa';
        }

        if(!isset($post->student_gender) || $post->student_gender == '') {
            $messageError[] = 'Harap mengisi jenis kelamin siswa';
        }

        if(!isset($post->student_phone) || $post->student_phone == '') {
            $messageError[] = 'Harap mengisi no hp siswa';
        }

        if(!isset($post->student_parent_phone) || $post->student_parent_phone == '') {
            $messageError[] = 'Harap mengisi no hp siswa';
        }

        if(count($messageError) > 0) {
            return $this->sendRespond(
                400,
                'Error.',
                $messageError
            );
        }

        $student = new Student();
        $student->db->transBegin();

        try {
            $isEdit = false;
            
            if(isset($post->student_id) && $post->student_id != '') {
                $isEdit = true;
            } 

            $data = [
                "student_nis" => $post->student_nis ?? '',
                "student_nisn" => $post->student_nisn ?? '',
                "student_password" => $post->student_password ?? '',
                "student_full_name" => $post->student_full_name ?? '',
                "student_gender" => $post->student_gender ?? '',
                "student_born_place" => $post->student_born_place ?? '',
                "student_born_date" => $post->student_born_date ?? '',
                "student_img" => $post->student_img ?? '',
                "student_phone" => $post->student_phone ?? '',
                "student_hobby" => $post->student_hobby ?? '',
                "student_address" => $post->student_address ?? '',
                "student_name_of_mother" => $post->student_name_of_mother ?? '',
                "student_name_of_father" => $post->student_name_of_father ?? '',
                "student_parent_phone" => $post->student_parent_phone ?? '',
                "class_class_id" => isset($post->class_class_id) && $post->class_class_id != '' ? $post->class_class_id : null,
                "majors_majors_id" => isset($post->majors_majors_id) && $post->majors_majors_id != '' ? $post->majors_majors_id : null,
                "student_status" => $post->student_status ?? '',
            ];

            if($isEdit) {
                $data = [
                    ...$data,
                    'student_last_update' => date('Y-m-d H:i:s')
                ];
                $student->update(['student_id', $post->student_id], $data);
            } else {
                $data = [
                    ...$data,
                    'student_input_date' => date('Y-m-d H:i:s')
                ];
                $student->insert($data);
            }

            $student->db->transCommit();

            return $this->sendRespond(
                200,
                'Siswa berhasil ' . ($isEdit ? 'diubah.' : 'ditambah.'),
            );
        } catch (\Exception $e) {
            $student->db->transRollback();
            return $this->sendRespond(
                400,
                'Error insert ' . $e->getMessage() . " line : " . $e->getLine()
            );
        }
    }

    public function deleteStudent()
    {
        $post = $this->request->getVar();

        if(isset($post->student_id) && $post->student_id != '') {
            $student = new Student();
            $student->db->transBegin();

            try {
                if($student->find($post->student_id)) {
                    $student->delete($post->student_id);
                } else {
                    return $this->sendRespond(
                        400,
                        'Data tidak ditemukan.'
                    );
                }

                $student->db->transCommit();

                return $this->sendRespond(
                    200,
                    'Siswa berhasil dihapus.'
                );
            } catch (\Exception $e) {
                $student->db->transRollback();
                return $this->sendRespond(
                    400,
                    'Error delete ' . $e->getMessage() . " line : " . $e->getLine()
                );
            }
        } else {
            return $this->sendRespond(
                400,
                'Param tidak lengkap.'
            );
        }
        
    }
}

