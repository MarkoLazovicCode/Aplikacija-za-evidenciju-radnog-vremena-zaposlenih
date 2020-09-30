<?php
    namespace App\Core\Role;

    class UserRoleController extends \App\Core\Controller {
        public function __pre() {
            
            if($this->getSession()->get('administrator_id') === null){
                $this->redirect('/admin');
            }
        }
    }