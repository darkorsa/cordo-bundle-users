<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command;

use Cordo\Core\Application\Queue\QueueMessage;

class SendUserWelcomeMessage extends QueueMessage
{
    public function __construct(
        public readonly string $email,
        public readonly string $locale,
    ) {
    }
}
