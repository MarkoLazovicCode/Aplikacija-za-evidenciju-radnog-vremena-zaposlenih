<?php
namespace App\Models;

use App\Core\Field;
use App\Core\Model;
use App\Validators\NumberValidator;

    class AccountModel extends Model {
        protected function getFields(): array {
            return [
                'account_id' =>         new Field((new NumberValidator())->setIntegerLength(10),false),
                'employee_id' =>        new Field((new NumberValidator())->setIntegerLength(10),true)
             ];  
        }  
}