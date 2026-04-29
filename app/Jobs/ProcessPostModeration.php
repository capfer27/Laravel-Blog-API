<?php

namespace App\Jobs;

use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessPostModeration implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if ($this->post->trashed()) {
            Log::info("The post was deleted. Skipping...");
            return;
        }

        //  Randomly set the post status: Published (80% chance) or Rejected (20% chance)
        $newStatus = (rand(1, 100) <= 80) ? PostStatus::PUBLISHED : PostStatus::REJECTED;

        $this->post->status = $newStatus;
        $this->post->moderated_at = now();

        if ($newStatus === PostStatus::PUBLISHED) {
            $this->post->published_at = now();
        }

        $this->post->save();

        // Simulation: Log the notification fact
        Log::info("Notification Sent: Post #{$this->post->id} is now {$newStatus->value}");

        // Send notification (imitation via log)
        //$this->post->notify(new PostModerationNotification($newStatus));
    }
}
