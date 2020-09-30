<?php
    namespace App\Controllers;

    class ApiDashboardController extends \App\Core\ApiController {
        public function show($datesInput){
            $dates = explode("=", $datesInput);

            $inputDateMin = $dates[0];
            $inputDateMax = $dates[1];
            
            $dateMin;
            $dateMax;
            if (!($inputDateMin && $inputDateMax)) {
                $dateMin = date("Y-m-d ") . ' 00:00:00';
                $dateMax = date("Y-m-d ") . ' 23:59:59';
            } else {
                $dateMin = $inputDateMin . ' 00:00:00';
                $dateMax = $inputDateMax . ' 23:59:59';
            }
            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $records = $recordModel->getReccordsByDateRange($dateMin, $dateMax);
            
            $this->set('records',  $records);
        }

        public function getTotalTimeByDateRange($dataInput){
            $data = explode("=", $dataInput);
            $employeeId = $data[0];
            $inputDateMin = $data[1];
            $inputDateMax = $data[2];
            
            $dateMin;
            $dateMax;
            if (!($inputDateMin && $inputDateMax)) {
                $dateMin = date("Y-m-d ") . ' 00:00:00';
                $dateMax = date("Y-m-d ") . ' 23:59:59';
            } else {
                $dateMin = $inputDateMin . ' 00:00:00';
                $dateMax = $inputDateMax . ' 23:59:59';
            }
            $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
            $account = $accountModel->getByFieldName('employee_id',$employeeId);

            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $records = $recordModel->getLogedInTimeByDateRange($account->account_id,$dateMin,$dateMax);
            
            $this->set('records',  $records);
        }

    }