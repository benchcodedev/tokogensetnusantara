<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\User;
use App\Services\AiDesignService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateAiThemeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 60;
    public int $tries = 2;

    public function __construct(
        public Event $event,
        public string $prompt,
        public ?string $referenceImagePath = null,
        public bool $allowCustomCss = false,
        public ?int $previousVersionId = null,
        public ?User $user = null
    ) {}

    public function handle(AiDesignService $service): array
    {
        return $service->generate(
            $this->event,
            $this->prompt,
            $this->referenceImagePath,
            $this->allowCustomCss,
            $this->previousVersionId,
            $this->user
        );
    }
}
