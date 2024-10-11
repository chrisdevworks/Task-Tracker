# Task-Tracker

## Christopher Christian Cosingan

📌 https://roadmap.sh/projects/task-tracker

> [!NOTE]
> https://roadmap.sh/projects/task-tracker/solutions?u=6709613dfb4be684db36cbc9

## Command Usage Examples
1. Adding a new task:
   - `php task-cli.php add "Buy groceries"`
   - Output:
     - `Task added successfully (ID: 1)`
2. Updating a task:
   - `php task-cli.php update 1 "Buy groceries and cook dinner"`   
3. Deleting a task:
   - `php task-cli.php delete 1`
4. Marking a task as in-progress:
   - `php task-cli.php mark-in-progress 1`
5. Marking a task as done:
   - `php task-cli.php mark-done 1`
6. Listing all tasks:
   - `php task-cli.php list`
7. Listing tasks by status:
   - Done tasks:
     - `php task-cli.php list done`
   - Todo tasks:
     - `php task-cli.php list todo`
   - Tasks in progress:
     - `php task-cli.php list in-progress`



## How the Program Works
1. Task Addition: The `add` command adds a new task with a status of `todo`.
2. Task Update: The `update` command updates the task description for a given ID.
3. Task Deletion: The `delete` command removes the task with the specified ID.
4. Task Status: The `mark-in-progress` and `mark-done` commands change the status of a task.
5. Task Listing: The `list` command without any argument lists all tasks. You can filter by status using `list done`, `list todo`, and `list in-progress`.
