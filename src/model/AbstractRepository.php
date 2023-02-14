<?php

namespace App\model;

abstract class AbstractRepository
{

    abstract protected function getTableName():string;
    public function delete($id){
            $table = $this->getTableName();
            $sql = "DELETE FROM $table WHERE id=$id";

            $query = Database::getInstance()->exec($sql);

    }

}