<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Command\Handler;

use Laminas\Mail\Message;
use League\Plates\Engine;
use Symfony\Contracts\Translation\TranslatorInterface;
use Cordo\Core\Infractructure\Mailer\ZendMail\MailerInterface;
use App\Context\Users\Application\Command\SendUserWelcomeMessage;

class SendUserWelcomeMessageHandler
{
    private $mailer;

    private $templates;

    private $translator;

    public function __construct(MailerInterface $mailer, Engine $templates, TranslatorInterface $translator)
    {
        $this->mailer = $mailer;
        $this->templates = $templates;
        $this->translator = $translator;
    }

    public function __invoke(SendUserWelcomeMessage $command): void
    {
        $body = $this->templates->render('context.users::mail/new-user-welcome', [
            'message' => $this->translator->trans('welcome.mail.message', [], 'mail', $command->locale)
        ]);
        $subject = $this->translator->trans('welcome.mail.subject', [], 'mail', $command->locale);

        $message = new Message();
        $message->addTo($command->email)
            ->addFrom('noreply@codeninjas.pl')
            ->setSubject($subject)
            ->setBody($body);

        $this->mailer->send($message);
    }
}
