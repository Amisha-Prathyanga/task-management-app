<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TasksExport implements FromQuery, WithHeadings, WithTitle
{
    /**
     * Get the query for the tasks.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Task::query(); 
    }

    /**
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Title',
            'Due Date',
            'Priority',
            'Description',
            'Is Completed',
            'Is Paid',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Set the sheet title.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Tasks'; 
    }
}
