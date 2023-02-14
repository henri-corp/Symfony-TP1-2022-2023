<?php

namespace App\model;

class TaskRepository extends AbstractRepository
{
    const TABLE = "tasks";

    public function initialize(): bool
    {
        $table = self::TABLE;

        if ($this->tableExists()) {
            return false;
        }

        Database::getInstance()->exec("
        create table $table 
        (
            id INTEGER
                constraint tasks_pk
                    primary key autoincrement,
            name TEXT,
            checked INTEGER default 0
        );
        INSERT INTO $table (id, name, checked) VALUES (1, 'Task to be done', 0);
        INSERT INTO $table (id, name, checked) VALUES (2, 'Task done', 1);
        ");
        return true;
    }


    private function tableExists(): bool
    {
        $table = self::TABLE;
        $result = Database::getInstance()->query("
            SELECT 1 
            FROM sqlite_master 
            WHERE type='table' 
              AND name='$table'");

        $result = $result->fetchAll();
        return count($result) > 0;
    }

    public function getAll(): array
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM $table ORDER BY checked DESC;";

        $result = Database::getInstance()->query($sql);

        return $result->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function update($id, $checked = false)
    {
        $table = self::TABLE;
        $sql = "UPDATE $table set checked=:checked WHERE id=$id";

        $query = Database::getInstance()->prepare($sql);
        $query->execute(["checked" => $checked]);
    }

    public function add($description)
    {
        $table = self::TABLE;
        $sql = "INSERT INTO $table (name) values(:descr)";

        $query = Database::getInstance()->prepare($sql);
        $query->execute(["descr" => $description]);

    } //ajouter une task

    protected function getTableName(): string
    {
        return self::TABLE;
    }
}