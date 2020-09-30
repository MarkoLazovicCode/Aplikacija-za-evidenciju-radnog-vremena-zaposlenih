<?php
namespace App\Models;

use App\Core\Field;
use App\Core\Model;
use App\Validators\NumberValidator;
use App\Validators\StringValidator;
use App\Validators\DateTimeValidator;

    class AdministratorModel extends Model{
        protected function getFields(): array {
            return [
                'administrator_id' =>         new Field((new NumberValidator())->setIntegerLength(10),false),
                'name' =>               new Field((new StringValidator())->setMaxLength(45),true),
                'lastname' =>           new Field((new StringValidator())->setMaxLength(45),true),
                'username' =>           new Field((new StringValidator())->setMaxLength(45),true),
                'password_hash' =>      new Field((new StringValidator())->setMaxLength(128),true),
                'email' =>              new Field((new StringValidator())->setMaxLength(45),true),
                'created_at' =>          new Field((new DateTimeValidator())->allowDate()->allowTime(),false)
             ];
        }     
}