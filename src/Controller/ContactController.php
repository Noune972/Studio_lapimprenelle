<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        MailerInterface $mailer,
        RateLimiterFactory $contactFormLimiter,
    ): Response {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*
             * 1. Honeypot
             */
            if ($form->get('website')->getData()) {

                $this->addFlash(
                    'success',
                    'Votre message a bien été envoyé, merci !'
                );

                return $this->redirectToRoute('app_contact');
            }


            /*
             * 2. Rate limiting
             */
           $limiter = $contactFormLimiter->create(
           $request->getClientIp() ?? 'unknown'
           );
            

            $limit = $limiter->consume(1);

            if (!$limit->isAccepted()) {

                $this->addFlash(
                    'error',
                    'Trop de demandes ont été envoyées. Merci de réessayer dans quelques minutes.'
                );

                return $this->redirectToRoute('app_contact');
            }


            /*
             * 3. Données validées
             */
            $data = $form->getData();


            /*
             * 4. Création de l'email
             */
            $email = (new Email())
                ->from('contact@tempo-agenceweb.com')
                ->to('contact@tempo-agenceweb.com')
                ->replyTo($data['email'])
                ->subject(
                    'Nouveau message de contact — ' . $data['nom']
                )
                ->text(sprintf(
                    "Nom : %s\n".
                    "Email : %s\n".
                    "Téléphone : %s\n".
                    "Type de projet : %s\n".
                    "Budget : %s\n\n".
                    "Message :\n%s",

                    $data['nom'],
                    $data['email'],
                    $data['telephone'] ?: 'non renseigné',
                    $data['typeProjet'],
                    $data['budget'] ?: 'non renseigné',
                    $data['message']
                ));


            /*
             * 5. Envoi
             */
            $mailer->send($email);


            /*
             * 6. Confirmation
             */
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé, merci !'
            );


            /*
             * PRG : Post / Redirect / Get
             * Empêche également le renvoi du formulaire
             * lors d'un rafraîchissement.
             */
            return $this->redirectToRoute('app_contact');
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}