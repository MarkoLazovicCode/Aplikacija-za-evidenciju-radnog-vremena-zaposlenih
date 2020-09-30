<?php

namespace App\Controllers;
class MainController extends \App\Core\Controller {
    public function home() {
        $staraVrednost = $this->getSession()->get('brojac', 0);
        $novaVrednost= $staraVrednost + 1;

        $this->getSession()->put('brojac', $novaVrednost);
    }

    public function postRecord(){
        $accountId = \filter_input(INPUT_POST,'account_id',FILTER_SANITIZE_STRING);

        
        $accountModel = new \App\Models\AccountModel($this->getDatabaseConnection());
        $account = $accountModel->getById($accountId);

        if(!$account){
            header('Location: /');
            exit;
        }

        $recordModel = new \App\Models\RecordModel($this->getDatabaseConnection());
        $recordModel->add(
            [
            'account_id'=>$accountId
            ]
        );
        $record = $recordModel->getReccordByAccountId($accountId);   
        $this->set('record', $record);
    }
    
    public function postLogin(){
        
    }
    public function getLogout() {
        $this->getSession()->remove('administrator_id');
        $this->getSession()->save();
        $this->redirect('/admin/profile/');
    }
   
}