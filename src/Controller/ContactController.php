<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
            ->from('contact@lapimprenelle.fr')
            ->to('contact@lapimprenelle.fr')
            ->replyTo($data['email'])
            ->subject('Nouveau message de contact — ' . $data['nom'])
            ->text(sprintf(
        "Nom : %s\nEmail : %s\nTéléphone : %s\nType de projet : %s\nBudget : %s\n\nMessage :\n%s",
        $data['nom'],
        $data['email'],
        $data['telephone'] ?? 'non renseigné',
        $data['typeProjet'],
        $data['budget'] ?? 'non renseigné',
        $data['message']
    ));
            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé, merci !');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}