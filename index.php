<?php
require 'vendor/autoload.php';

use App\model\Database;

define("DATABASE_FILE", "data.db");

Database::initialize(DATABASE_FILE);

$taskRepository = new \App\model\TaskRepository();

if ($taskRepository->initialize()) {
    header("Location: /");
}


if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "uncheck":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->update($id, false);
            }
            break;
        case "check":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->update($id, true);

            }
            break;
        case "delete":
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $taskRepository->delete($id);
            }
            break;
        case "add":
            if (isset($_GET["name"])) {
                $name = $_GET["name"];
                $taskRepository->add($name);
            }
            break;
        default:
            echo "An error has occured";
            die();
    }
    header("Location: /");

}


$tasks = $taskRepository->getAll();

require "template.php";