<?php

namespace Wanasni\TrajetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Wanasni\TrajetBundle\Entity\Trajet;
use Wanasni\TrajetBundle\Form\TrajetType;


class TrajetController extends Controller
{
    /**
     * @Route("/proposer", name="trajet_proposer" )
     */
    public function ProposerAction()
    {

        $trajet = new Trajet();
        // On crée le formulaire grâce à la TrajetType
        $form = $this->createForm(new TrajetType(), $trajet);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($trajet);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Trajet bien ajouté');

                return $this->redirect($this->generateUrl(
                    'trajet_show',
                    array('id' => $trajet->getId())
                ));

            }

        }

        return $this->render(':Trajet/Proposer:proposer.html.twig',
            array(
                'form'=>$form->createView(),
            ));


    }



    /**
     *
     * @Route("/voir-trajet/{id}", name="trajet_show")
     */
    public function ShowAction($id)
    {
        return $this->render(':Trajet/Gerer:voir_trajet.html.twig',
            array(
                'id'=>$id,
            ));
    }

}
