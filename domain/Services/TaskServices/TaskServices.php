<?php

namespace domain\Services\TaskServices;

use App\Models\ProductCategory;
use App\Models\Task;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskStatusChanged;

class TaskServices
{
    protected $task;
    public function __construct()
    {
        $this->task = new Task();

    }

    public function all()
    {
        return $this->task->all();
    }

    public function store(array $data)
    {
            $this->task->create($data);

    }

    public function get($id)
    {
        return $this->task->findOrFail($id);
    }

    public function getCategory($category_id)
    {
        return $this->task->where('id', $category_id)->first();
    }

    public function update($id, $data)
    {
        $data['updated_by'] = Auth::user()->id;

        $category = $this->task->findOrFail($id);

            $category->update($data);
    }

    public function delete(int $task_id)
    {
        return $this->task->find($task_id)->delete();
    }

    public function change(int $task_id)

   {
    $task = $this->task->find($task_id);

    if ($task) {
        $task->status = $task->status == 0 ? 1 : 0;
        $status = $task->status == 1 ? 'complete' : 'incomplete';
         Notification::route('mail',"lakshan@gmail.com")
                ->notify(new TaskStatusChanged($task, $status));
        return $task->save();

    }
    return false;
}

}
