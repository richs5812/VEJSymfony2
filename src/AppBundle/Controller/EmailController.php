<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Contact;

class EmailController extends Controller
{
	/**
     * @Route("/send/email", name="email")
     */
	public function emailAction()
	{
		$contact = new Contact();
		$contact->setFirstName('Rich');
		$message = \Swift_Message::newInstance()
			->setSubject('Hello Email')
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

		return new Response('email sent?');
	}
}
