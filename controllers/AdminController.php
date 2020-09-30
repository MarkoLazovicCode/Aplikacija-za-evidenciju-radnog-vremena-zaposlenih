<?php

namespace App\Controllers;
class AdminController extends \App\Core\Controller {
    public function getlogin() {

    }
    public function postLogin() {
        $username = \filter_input(INPUT_POST,'login_username',FILTER_SANITIZE_STRING);
        $password = \filter_input(INPUT_POST,'login_password',FILTER_SANITIZE_STRING);
        $asd = \password_hash($password,1);
        print_r($asd);
        $validanPassword = (new \App\Validators\StringValidator())->setMinLength(7)->setMaxLength(120)->isValid($password);

        if(!$validanPassword){
            $this->set('message', 'Doslo je do greske: Lozinka nije ispravnog formata.');
            return;
        }

        $administratorModel = new \App\Models\AdministratorModel($this->getDatabaseConnection());
        $admin = $administratorModel->getByFieldName('username', $username);
        if(!$admin){
            $this->set('message', 'Doslo je do greske: Ne postoji korisnik sa tim imenom!');
            return;
        }

        if(!password_verify($password, $admin->password_hash)){
            sleep(1);
            $this->set('message', 'Doslo je do greske: Lozinka nije ispravna.');
            return;
        }
        
        $this->getSession()->put('administrator_id', $admin->administrator_id);
        $this->getSession()->save();   
        
        $this->redirect('/admin/profile/');
    }
    
}