<?php

namespace App\Listeners;

use App\Events\TaskCompletedEvent;
use App\Mail\TaskCompletedMail;
use Illuminate\Support\Facades\Mail;

class SendTaskCompletionEmail
{
    public function handle(TaskCompletedEvent $event)
    {
        try {
            $recipientEmail = $event->task->user->email ?? config('mail.from.address');
            
            Log::info('Attempting to send task completion email', [
                'task_id' => $event->task->id,
                'recipient' => $recipientEmail
            ]);

            Mail::to($recipientEmail)->send(new TaskCompletedMail($event->task));

            Log::info('Task completion email sent successfully', [
                'task_id' => $event->task->id,
                'recipient' => $recipientEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send task completion email', [
                'task_id' => $event->task->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}
