<?php

namespace Yoda\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yoda\UserBundle\Entity\User;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template
     */
    public function registerAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', 'text')
            ->add('email',    'email')
            ->add('password', 'repeated', array(
                'type' => 'password'
            ))
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $user = new User();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($this->_encodePassword($user, $data['password']));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('event');
            return $this->redirect($url);
        }
        return array('form' => $form->createView());
    }

    private function _encodePassword(User $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
}