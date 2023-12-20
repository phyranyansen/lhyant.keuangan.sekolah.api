<?php

namespace App\Controllers\Service\Master;

use App\Controllers\Service\ApiController;
use App\Controllers\BaseController;
use App\Models\PeriodeModel;
use App\Models\Student;
use Exception;

class PeriodController extends ApiController
{
    private $periodModel;

    public function __construct()
    {
        $this->periodModel = new PeriodeModel();
    }

    public function activePeriod()
    {
        $periodActive = $this->periodModel->checkActivePeriod();
        return $this->sendRespond(
            $periodActive != null ? 200 : 400,
            'Periode Aktif',
            $periodActive
        );
    }

    public function getAllPeriod()
    {
        $request = $this->request->getVar();

        $period = $this->periodModel->select('*');

        if(isset($request->period_id)) {
            $period->where('period_id', $request->period_id);
        }

        $period = $period->orderBy('period_id', 'asc')->get()->getResult();

        return $this->sendRespond(
            200,
            'Period',
            $period
        );
    }

    public function addOrUpdatePeriod()
    {
        $request = $this->request->getVar();
        
        $messageError = [];
        if(!isset($request->period_start) || $request->period_start == '') {
            $messageError[] = 'Silahkan mengisi awal periode';
        }

        if(!isset($request->period_end) || $request->period_end == '') {
            $messageError[] = 'Silahkan mengisi akhir periode';
        }

        if(!isset($request->period_status) || $request->period_status == '') {
            $messageError[] = 'Silahkan mengisi status periode';
        }

        if(is_array($messageError) && count($messageError) > 0) {
            return $this->sendRespond(
                400,
                'Error.',
                $messageError
            );
        }

        $this->periodModel->db->transBegin();

        try {

            $isEdit = false;
            if(isset($request->period_id) && $request->period_id != '') {
                $isEdit = true;
            }

            $data = [
                'period_start' => $request->period_start,
                'period_end' => $request->period_end,
                'period_status' => $request->period_status
            ];

            if($isEdit) {
                $this->periodModel->update(['period_id' => $request->period_id], $data);
            } else {
                $this->periodModel->insert($data);
            }

            $this->periodModel->db->transCommit();
            return $this->sendRespond(
                200,
                'Sukses ' . ($isEdit ? 'Update' : 'Insert') . ' Periode'
            );

        } catch (\Exception $e) {
            $this->periodModel->db->transRollback();
            return $this->sendRespond(
                400,
                'Error insert ' . $e->getMessage() . ' line: ' . $e->getLine()
            );
        }
    }
}