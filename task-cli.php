<?php

// Path to the JSON file where tasks will be stored
define('TASKS_FILE', 'tasks.json');

// Load tasks from the JSON file
function loadTasks() {
    if (!file_exists(TASKS_FILE)) {
        file_put_contents(TASKS_FILE, json_encode([]));
    }
    $json = file_get_contents(TASKS_FILE);
    return json_decode($json, true);
}

// Save tasks to the JSON file
function saveTasks($tasks) {
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

// Add a new task
function addTask($description) {
    $tasks = loadTasks();
    $id = count($tasks) + 1;
    $tasks[] = ['id' => $id, 'description' => $description, 'status' => 'todo'];
    saveTasks($tasks);
    echo "Task added successfully (ID: $id)\n";
}

// Update an existing task
function updateTask($id, $newDescription) {
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['description'] = $newDescription;
            saveTasks($tasks);
            echo "Task updated successfully.\n";
            return;
        }
    }
    echo "Task with ID $id not found.\n";
}

// Delete a task
function deleteTask($id) {
    $tasks = loadTasks();
    foreach ($tasks as $key => $task) {
        if ($task['id'] == $id) {
            unset($tasks[$key]);
            saveTasks(array_values($tasks));  // Re-index array
            echo "Task deleted successfully.\n";
            return;
        }
    }
    echo "Task with ID $id not found.\n";
}

// Mark a task as 'in progress'
function markInProgress($id) {
    changeTaskStatus($id, 'in-progress');
}

// Mark a task as 'done'
function markDone($id) {
    changeTaskStatus($id, 'done');
}

// Helper to change task status
function changeTaskStatus($id, $status) {
    $tasks = loadTasks();
    foreach ($tasks as &$task) {
        if ($task['id'] == $id) {
            $task['status'] = $status;
            saveTasks($tasks);
            echo "Task status updated to '$status'.\n";
            return;
        }
    }
    echo "Task with ID $id not found.\n";
}

// List all tasks or tasks by specific status
function listTasks($filterStatus = null) {
    $tasks = loadTasks();
    if (!$tasks) {
        echo "No tasks found.\n";
        return;
    }
    foreach ($tasks as $task) {
        if ($filterStatus === null || $task['status'] == $filterStatus) {
            echo "{$task['id']}: {$task['description']} [{$task['status']}]\n";
        }
    }
}

// CLI Command Handler
if ($argc < 2) {
    echo "Usage: php task-cli.php <command> [options]\n";
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'add':
        if (isset($argv[2])) {
            addTask($argv[2]);
        } else {
            echo "Please provide a task description.\n";
        }
        break;

    case 'update':
        if (isset($argv[2]) && isset($argv[3])) {
            updateTask($argv[2], $argv[3]);
        } else {
            echo "Usage: php task-cli.php update <id> <new description>\n";
        }
        break;

    case 'delete':
        if (isset($argv[2])) {
            deleteTask($argv[2]);
        } else {
            echo "Usage: php task-cli.php delete <id>\n";
        }
        break;

    case 'mark-in-progress':
        if (isset($argv[2])) {
            markInProgress($argv[2]);
        } else {
            echo "Usage: php task-cli.php mark-in-progress <id>\n";
        }
        break;

    case 'mark-done':
        if (isset($argv[2])) {
            markDone($argv[2]);
        } else {
            echo "Usage: php task-cli.php mark-done <id>\n";
        }
        break;

    case 'list':
        if (isset($argv[2])) {
            switch ($argv[2]) {
                case 'done':
                    listTasks('done');
                    break;
                case 'todo':
                    listTasks('todo');
                    break;
                case 'in-progress':
                    listTasks('in-progress');
                    break;
                default:
                    echo "Invalid status. Use 'done', 'todo', or 'in-progress'.\n";
            }
        } else {
            listTasks();
        }
        break;

    default:
        echo "Unknown command: $command\n";
        echo "Available commands: add, update, delete, mark-in-progress, mark-done, list\n";
        break;
}
