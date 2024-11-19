@component('mail::message')
# Task Completed: {{ $task->title }}

The task has been marked as completed.

**Task Details:**
- Title: {{ $task->title }}
- Description: {{ $task->description }}
- Completed Date: {{ $task->updated_at->format('Y-m-d H:i:s') }}

@component('mail::button', ['url' => url('/tasks/' . $task->id)])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent