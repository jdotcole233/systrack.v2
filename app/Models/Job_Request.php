<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
}
