<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterService extends AbstractController
{
    private $entityManager, $mailer;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->entityManager = $em;
        $this->mailer = $mailer;
    }

    public function newUser(User $user, FormInterface $form, UserPasswordEncoderInterface $passwordEncoder): ?User
    {
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );
        $user->setRoles([User::ROLE_USER]);
        $random = (string)uniqid();
        $user->setVerifyCode($random);

        $this->entityManager->persist($user);
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception("Exception.");
        }

        // do anything else you need here, like send an email

        $this->sendWelcomeMail($user);

        return $user;
    }

    public function sendWelcomeMail(User $user): void
    {
        $email = (new TemplatedEmail())
            ->from('tanya_yurgina@mail.ru')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->htmlTemplate('email/welcome.html.twig')
            ->context([
                'name' => $user->getFirstName(),
            ]);

        $this->mailer->send($email);
    }
}