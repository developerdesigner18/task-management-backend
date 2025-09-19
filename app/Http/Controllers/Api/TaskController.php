<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ReorderTaskRequest;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Http\Traits\ResponseTrait;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            $task = Task::query()->orderBy('order', 'asc');

            if ($request->has('status')) {
                switch ($request->get('status')) {
                    case 'completed':
                        $task->where('completed', true);
                        break;
                    case 'pending':
                        $task->where('completed', false);
                        break;
                }
            }

            if ($request->has('search')) {
                $task->where('title', 'like', '%' . $request->get('search') . '%');
            }

            $task = $task->get();

            return $this->sendResponse('Task list', $task);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreTaskRequest $request)
    {
        try {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->order = Task::max('order') + 1;
            $task->save();

            return $this->sendResponse('Task created', $task);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return $this->sendError('Task not found', 404);
            }

            return $this->sendResponse('Task show', $task);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update($id, UpdateTaskRequest $request)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return $this->sendError('Task not found', 404);
            }

            $task->title = $request->title;
            $task->description = $request->description;
            if ($request->has('completed')) {
                $task->completed = $request->completed;
            }
            $task->save();

            return $this->sendResponse('Task updated', $task);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return $this->sendError('Task not found', 404);
            }

            $task->delete();

            return $this->sendSuccess('Task deleted');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function reorder(ReorderTaskRequest $request)
    {
        try {
            foreach ($request->tasks as $taskData) {
                $task = Task::find($taskData['id']);
                if ($task) {
                    $task->order = $taskData['order'];
                    $task->save();
                }
            }

            return $this->sendSuccess('Tasks reordered');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function complete(Request $request,$id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return $this->sendError('Task not found', 404);
            }

            $task->completed = $request->has('completed') ? $request->completed : true;
            $task->save();

            return $this->sendSuccess('Task completed');

        }catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
