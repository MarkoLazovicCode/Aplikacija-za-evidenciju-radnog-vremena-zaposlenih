<?php

    namespace App\Controllers;
    
    class AdminDashboardController extends \App\Core\Role\UserRoleController {

        public function index(){
            $dateMin = date("Y-m-d ") . ' 00:00:00';
            $dateMax = date("Y-m-d ") . ' 23:59:59';
            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $records = $recordModel->getReccordsByDateRange($dateMin, $dateMax);
            
            $this->set('records', $records);
            
        }

        public function getEmployees(){
            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employees = $employeeModel->getAll();
            
            $this->set('employees', $employees);
            
        }
        public function getEmployee($id){
            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employees = $employeeModel->getById($id);
            $this->set('employee', $employees);

            $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
            $account = $accountModel->getByFieldName('employee_id',$id);
            $this->set('account', $account);
            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $records = $recordModel->getTotalLogedInTime($account->account_id);
            
            $this->set('records', $records);
            
        }
        public function getAddEmployee(){
   
        }
        public function postAddEmployee(){
            $employeeName = \filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
            $employeeLastname = \filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_STRING);
            $employeeAddress = \filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
            $employeePhone = \filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
            $employeeMail = \filter_input(INPUT_POST,'mail',FILTER_SANITIZE_STRING);

            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employeeId = $employeeModel->add(
                [
                'name'=>$employeeName,
                'lastname'=>$employeeLastname,
                'address'=>$employeeAddress,
                'phone'=>$employeePhone,
                'mail'=>$employeeMail
                ]
            );
            $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
            $accountModel->add(
                [
                'employee_id'=>$employeeId
                ]
            );
            header('Location: /admin/profile/employees');
        }

        public function getEditEmployee(int $employeeId){
            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employee = $employeeModel->getById($employeeId);
            
            $this->set('employee', $employee);
        }
        public function postEditEmployee(int $employeeId){
            $employeeName = \filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
            $employeeLastname = \filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_STRING);
            $employeeAddress = \filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
            $employeePhone = \filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
            $employeeMail = \filter_input(INPUT_POST,'mail',FILTER_SANITIZE_STRING);

            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employeeModel->editById($employeeId,[
                'name'=>$employeeName,
                'lastname'=>$employeeLastname,
                'address'=>$employeeAddress,
                'phone'=>$employeePhone,
                'mail'=>$employeeMail

            ]);
            $employee = $employeeModel->getById($employeeId);
           
            $this->set('employee', $employee);
        }

        public function getArchivedEmployees(){
            $archivedEmployeeModel = new \App\Models\ArchivedModel($this->getDatabaseConnection());
            $employees = $archivedEmployeeModel->getAll();
            
            $this->set('employees', $employees);
        }

        public function getArchiveEmployee($employeeId){
            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employee = $employeeModel->getById($employeeId);
            
            $this->set('employee', $employee);
        }

        public function postArchiveEmployee($employeeId){
            $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
            $account = $accountModel->getByFieldName('employee_id',$employeeId);

            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $recordModel->deletetAccountById($account->account_id);

            $accountModel->deletetById($account->account_id);

            $employeeModel = new \App\Models\EmployeeModel($this->getDatabaseConnection());
            $employeeModel->deletetById($employeeId);

            $employeeName = \filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
            $employeeLastname = \filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_STRING);
            $employeeAddress = \filter_input(INPUT_POST,'address',FILTER_SANITIZE_STRING);
            $employeePhone = \filter_input(INPUT_POST,'phone',FILTER_SANITIZE_STRING);
            $employeeMail = \filter_input(INPUT_POST,'mail',FILTER_SANITIZE_STRING);

            $archivedEmployeeModel = new \App\Models\ArchivedModel($this->getDatabaseConnection());
            $archivedEmployee = $archivedEmployeeModel->add(
                [
                'name'=>$employeeName,
                'lastname'=>$employeeLastname,
                'address'=>$employeeAddress,
                'phone'=>$employeePhone,
                'mail'=>$employeeMail
                ]
            );
        }

        public function getAllRecords($employeeId){
            $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
            $account = $accountModel->getByFieldName('employee_id',$employeeId);

            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $records = $recordModel->getAllByFieldName("account_id",$account->account_id);

            $this->set('records', $records);
        }

        public function getEditRecord($recordId){
            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $record = $recordModel->getById($recordId);

            $this->set('record', $record);
        }
        public function postEditRecord($recordId){
            $created_at = \filter_input(INPUT_POST,'created_at',FILTER_SANITIZE_STRING);

            $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
            $recordModel->editById($recordId,[
                'created_at'=>$created_at,
            ]);

            $record = $recordModel->getById($recordId);
           
            $this->set('record', $record); 
        }
    }