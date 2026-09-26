<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Job_Request extends Model
{
    protected $fillable = ['client_id', 'job_id', 'status', 'job_priority', 'reference_number', 'details', 'job_cost', 'delete_status', 'created_by', 'start_date', 'hash_check'];

    public function job(): HasOne
    {
        return $this->hasOne(Job::class, 'job_id', 'job_id');
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'client_id', 'client_id');
    }

    protected $casts = [
        'details' => 'array',
    ];

    protected function applicantName(): Attribute
    {
        return Attribute::get(function () {
            $details = $this->details ?? [];

            foreach (['COMPANY NAME', 'NAME', 'APPLICANT', 'APPLICANT NAME'] as $key) {
                if (filled($details[$key] ?? null)) {
                    return $details[$key];
                }
            }

            return null;
        });
    }

    public function job_assignment(): HasMany
    {
        return $this->hasMany(Job_Assignment::class, 'job_request_id', 'job_request_id');
    }

    public function job_tasks_completion(): HasMany
    {
        return $this->hasMany(Job_Task_Completion::class, 'job_request_id', 'job_request_id')
            ->orderBy('job_task_completion_id', 'asc');
    }


    public function latest_job_task_completion()
    {
        return $this->hasOne(Job_Task_Completion::class, 'job_request_id', 'job_request_id')
            ->latestOfMany('created_at');
    }

    public function currentTask(): ?Task
    {
        $tasks  = $this->job->tasks;
        $lastId = $this->latestCompletedTask?->task_id;

        return $lastId === null
            ? $tasks->first()
            : $tasks->first(fn($t) => $t->task_id > $lastId);
    }

    public function isOnFinalTask(): bool
    {
        $current = $this->currentTask();
        return $current && $current->is($this->job->tasks->last());
    }

 
    public function completion()
    {
        return $this->hasOne(Job_Completion::class, 'job_request_id', 'job_request_id');
    }
 
    public function assignees()
    {
        return $this->belongsToMany(
            Employee::class,
            'job__assignments',
            'job_request_id', // FK on pivot → this model
            'emp_id',         // FK on pivot → Employee
            'job_request_id',
            'emp_id'
        )
            ->wherePivot('delete_status', 'NOT DELETED')
            ->where('employees.delete_status', 'NOT DELETED');
    }

        // job_tasks_completion() already exists (it's eager-loaded today) — no change needed.
 
    /**
     * Works out where this request is in its job's task sequence.
     * Expects job.tasks (ordered) and job_tasks_completion to be eager-loaded.
     *
     * Rule: the current task is the one after the FURTHEST task (in job order)
     * whose latest completion status is "completed". No more task_id + 1 arithmetic,
     * so gaps, deletions and tasks added later don't break it.
     */
    public function taskProgress(): array
    {
        $tasks = $this->job ? $this->job->tasks->values() : collect();
 
        // Latest status per task. Rows are ordered oldest → newest, so later ones win.
        $statuses = $this->job_tasks_completion
            ->where('delete_status', 'NOT DELETED')
            ->sortBy('created_at')
            ->mapWithKeys(fn ($c) => [$c->task_id => $c->status])
            ->all();
 
        $lastDone = -1;
        foreach ($tasks as $i => $task) {
            if (($statuses[$task->task_id] ?? null) === 'completed') {
                $lastDone = $i;
            }
        }
 
        $currentIndex = $lastDone + 1;
        $current      = $tasks->get($currentIndex);
 
        $stages = $tasks->map(fn ($task, $i) => [
            'id'     => $task->task_id,
            'name'   => $task->task_name,
            'state'  => $i <= $lastDone ? 'completed' : ($i === $currentIndex ? 'current' : 'pending'),
            'status' => $statuses[$task->task_id] ?? null,
        ])->all();
 
        return [
            'current'  => $current,
            'is_final' => $current !== null && $currentIndex === $tasks->count() - 1,
            'is_done'  => $tasks->isNotEmpty() && $current === null,
            'statuses' => $statuses,
            'stages'   => $stages,
        ];
    }
}
