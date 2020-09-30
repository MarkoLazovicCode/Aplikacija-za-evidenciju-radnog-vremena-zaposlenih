<?php
namespace App\Models;

use App\Core\Field;
use App\Core\Model;
use App\Validators\NumberValidator;
use App\Validators\DateTimeValidator;
use App\Validators\StringValidator;


    class RecordModel extends Model{
        protected function getFields(): array {
            return [
                'record_id' =>          new Field((new NumberValidator())->setIntegerLength(10),false),
                'account_id' =>         new Field((new NumberValidator())->setIntegerLength(10),true),
                'created_at' =>          new Field((new DateTimeValidator())->allowDate()->allowTime(),true),
                'status' =>             new Field((new StringValidator())->setMaxLength(2),false)
             ];
        }

        public function getReccordByAccountId(int $accountId){
            $sql = 'SELECT
            record.created_at,
            employee.name,
            employee.lastname,
            record.status
            FROM
            record,
            employee,
            account
            WHERE
            account.account_id = ? AND
            record.account_id = ? AND
            employee.employee_id = account.employee_id
            ORDER BY record.created_at DESC
            limit 1;';
            $prep = $this->getConnection()->prepare($sql);
            $res=$prep->execute([$accountId,$accountId]);
            $recors = null;
            if($res){
                $recors = $prep->fetch(\PDO::FETCH_OBJ);
            }
            return $recors;                                          
        }

        public function getReccordsByDateRange(string $dateMin , string $dateMax){
            $sql = 'SELECT record.record_id,
                record.account_id,
                record.created_at,
                employee.name,
                employee.lastname,
                record.status
            FROM
                record
                INNER JOIN account ON record.account_id = account.account_id
                INNER JOIN employee ON account.employee_id = employee.employee_id
            WHERE
                record.record_id IN (
			        SELECT MAX(record.record_id)
			        FROM record
			        GROUP BY record.account_id) 
                AND
                    record.created_at BETWEEN \''. $dateMin . '\' AND \'' . $dateMax .'\'
            ORDER BY record.created_at DESC;';
            $prep = $this->getConnection()->prepare($sql);
            $res=$prep->execute([]);
            $recors = [];
            if($res){
                $recors = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $recors;                                          
        }
        
        public function getTotalLogedInTime($accountId){
            $sql = 'SELECT
                        login_time, 
                        logout_time, 
                        timediff(logout_time, login_time) AS logged_in_time
                    FROM
                        (SELECT
                            account_id,
                            created_at AS login_time,
                            coalesce(
                                (SELECT created_at
                                FROM record t_out
                                WHERE 
                                    t_out.account_id = t_in.account_id
                                AND t_out.created_at >= t_in.created_at 
                                AND t_out.status = "OUT"
                                ORDER BY created_at 
                                LIMIT 1
                                ), 
                                now()
                        ) AS logout_time
                    FROM
                        record t_in
                    WHERE
                        account_id = ?
                    AND
                        status = "IN") AS q1 
                    ORDER BY
                        account_id, login_time ;';
            $prep = $this->getConnection()->prepare($sql);
            $res=$prep->execute([$accountId]);
            $recors = [];
            if($res){
                $recors = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $recors;                                          
        }

        public function getLogedInTimeByDateRange(int $accountId,string $dateMin , string $dateMax){
            $sql = 'SELECT
            login_time, 
            logout_time, 
            timediff(logout_time, login_time) AS logged_in_time
        FROM
        (SELECT
            account_id,
            created_at AS login_time,
            coalesce(
                (SELECT created_at
                    FROM record t_out
                    WHERE 
                        t_out.account_id = t_in.account_id
                        AND t_out.created_at >= t_in.created_at 
                        AND t_out.status = "OUT"
                        ORDER BY created_at 
                        LIMIT 1
                        ), 
                        now()
            ) AS logout_time
        FROM
            record t_in
        WHERE
            account_id = ?
            AND
            created_at BETWEEN \''. $dateMin . '\' AND \'' . $dateMax .'\'
            AND
            status = "IN") AS q1 
        ORDER BY
            account_id, login_time;';
            $prep = $this->getConnection()->prepare($sql);
            $res=$prep->execute([$accountId]);
            $recors = [];
            if($res){
                $recors = $prep->fetchAll(\PDO::FETCH_OBJ);
            }
            return $recors;                                          
        }
       
        public function deletetAccountById(int $id){
            $sql = 'DELETE FROM record WHERE account_id=?;';
            $prep = $this->getConnection()->prepare($sql);
            
            return $prep->execute([$id]);                                     
        }

}