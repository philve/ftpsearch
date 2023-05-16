<?php
require_once "config.php";

if (isset($_POST["filename"]) && isset($_POST["host"])) {
    $filename = urldecode($_POST["filename"]);
    $host = urldecode($_POST["host"]);

    // Load the list of tasks from the tasks.json file
    $tasks = array();

    if (file_exists(TASKS_FILE)) {
        $tasks = json_decode(file_get_contents(TASKS_FILE), true);
    }

    // Add the file to the list of tasks
    $tasks[] = array(
        "filename" => $filename,
        "host" => $host
    );

    // Save the list of tasks to the tasks.json file
    file_put_contents(TASKS_FILE, json_encode($tasks));

    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "Missing parameters"));
}
