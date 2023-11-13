<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Reception;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {

    $contact = new Contact();

    $contactForm = $this->createForm(ContactType::class, $contact);

    $contactForm->handleRequest($request);

    // dump($contactForm->getNormData());
    // dump($contactForm->getData());
    // dump($contactForm->getTransformationFailure());

    // $button = $contactForm->getClickedButton()->getConfig()->getName();

    // dump($button);
    // dump('BOUTON Submit');
    // dump($contactForm['envoyer']->getData());
    // dump($contactForm['clickedButton']['config']['name']->getData());

        if($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();
            dump('$contactForm est submitted et valid');
            dump($data);
            dump('contactForm', $contactForm);
            dump('bouton', $contactForm->getClickedButton()->getName());

            if ($contactForm->getClickedButton() && 'confirmer' === $contactForm->getClickedButton()->getName()) {

                    $reception = new Reception();

                //     dump('reception', $reception);


                // dd($contact);
                $em->persist($contact);
                //     // $em->flush();
                    $reception->setFirstname($data->getFirstname());
                    $reception->setLastname($data->getLastname());
                    $reception->setEmail($data->getEmail());
                    $reception->setComment($data->getComment());

                    // EMAIL
                    $email = (new TemplatedEmail())
                    ->from($contact->getEmail())
                    ->to('admin@example.com')
                    //->cc('cc@example.com')
                    //->bcc('bcc@example.com')
                    //->replyTo('fabien@example.com')
                    //->priority(Email::PRIORITY_HIGH)
                    ->subject('Formulaire de Contact')
                    ->htmlTemplate('emails/contact.html.twig')

                    // pass variables (name => value) to the template
                    ->context([
                        'contact' => $contact
                    ]);

                    // Utilisez l'adresse e-mail de réception
                    $toAddresses = $email->getTo();
                    $emailStrings = [];

                    foreach ($toAddresses as $address) {
                        $emailStrings[] = $address->getAddress();
                    }

                    $reception->setEmailRecept(implode(', ', $emailStrings));

                    // dd($email);
                    // dd($reception);
                    $em->persist($reception);
                    $em->flush();
                    dump($email);
                    $mailer->send($email);
                   

                $this->addFlash('success', 'Votre formulaire a été soumis avec succès !');
                return $this->redirectToRoute('app_contact');

            } else {
                $this->addFlash('warning', 'Votre formulaire doit être confirmé avant d\'être soumis!');
            }
        }
        

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
