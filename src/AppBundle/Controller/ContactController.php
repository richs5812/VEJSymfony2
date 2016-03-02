<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ContactType;
use AppBundle\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
		
		$contact = new Contact();
		$contactForm = $this->createForm(ContactType::class, $contact);
		
		$contactForm->handleRequest($request);

		if ($contactForm->isSubmitted() && $contactForm->isValid()) {	
			
			$message = \Swift_Message::newInstance()
				->setSubject('New Contact Received')
				->setFrom('voices4earth.org@gmail.com')
				->setTo('rich@detroitcitycentral.com')
				->setBody(
				$this->renderView(
					// app/Resources/views/Emails/registration.html.twig
					'default/registration.html.twig',
					array('contact' => $contact)
				),
				'text/html'
			)
				/*
				 * If you also want to include a plaintext version of the message
				->addPart(
					$this->renderView(
						'Emails/registration.txt.twig',
						array('name' => $name)
					),
					'text/plain'
				)
				*/
			;
			$this->get('mailer')->send($message);
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($contact);
			$em->flush();
			

			return $this->redirectToRoute('showPages');

		}
    
        // render form
        return $this->render('default/contact.html.twig', array(
            'contactForm' => $contactForm->createView(),
        ));
    }
}
