<?php

namespace Wanasni\TrajetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wanasni\TrajetBundle\Entity\Alert;
use Wanasni\TrajetBundle\Entity\Trajet;
use Wanasni\TrajetBundle\Form\AlertType;
use Wanasni\TrajetBundle\Form\TrajetRegulierType;
use Wanasni\TrajetBundle\Form\TrajetType;
use Wanasni\TrajetBundle\Form\TrajetUniqueType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Wanasni\TrajetBundle\Entity\Search;

class TrajetController extends Controller
{
    /**
     * @Route("/proposer-trajet", name="trajet_proposer_unique" )
     */
    public function ProposerAction()
    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $trajet = new Trajet();
        // On crée le formulaire grâce à la TrajetUniqueType
        $form = $this->createForm(new TrajetUniqueType($this->getUser()), $trajet);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $trajet->setConducteur($this->getUser());
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

        return $this->render(':Trajet/Proposer:proposer_trajet_unique.html.twig',
            array(
                'form' => $form->createView(),
            ));

    }


    /**
     * @Route("/proposer-trajet-regulier", name="trajet_proposer_regulier" )
     */
    public function ProposerRegulierAction()
    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $trajet = new Trajet();
        // On crée le formulaire grâce à la TrajetType
        $form = $this->createForm(new TrajetRegulierType($this->getUser()), $trajet);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $trajet->setConducteur($this->getUser());
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

        return $this->render(':Trajet/Proposer:proposer_trajet_regulier.html.twig',
            array(
                'form' => $form->createView(),
            ));

    }

    /**
     *
     * @Route("/voir-trajet/{id}", name="trajet_show")
     * @ParamConverter("trajet", class="WanasniTrajetBundle:Trajet")
     */
    public function ShowAction(Trajet $trajet)
    {
        return $this->render(':Trajet/Gerer:voir_trajet.html.twig',
            array(
                'trajet' => $trajet,
            ));
    }


    /**
     * @Route("/rechercher-trajet", name="trajet_search")
     */

    public function SearchAction(Request $request)
    {

        $search = new Search();
        $Trajets = null;

        if ($request->getMethod() == 'POST') {
            $search->setOrigine($request->get('search_origine'));
            $search->setDestination($request->get('search_destination'));
            $date = $request->get('search_date');
            $search->setDate($date);

            $em = $this->getDoctrine()->getManager();
            $rep = $em->getRepository('WanasniTrajetBundle:Trajet');
            $Trajets = $rep->SearchByOrigineAndDestination($search->getOrigine(), $search->getDestination(), $search->getDate());
            // On définit un message flash
            //$this->get('session')->getFlashBag()->add('info', 'Trajet Trouver');

        }


        return $this->render(':Trajet/Gerer:rechercher_trajet.html.twig', array(
            'search'=>$search,
            'trajets'=>$Trajets
        ));
    }


    /**
     * @Route("/resultat-rechercher-trajet", name="trajet_search_result")
     */
    public function ResultSearchAction(Request $request)
    {

    }


    public function AlertAction()
    {

        $alert=new Alert();

        $form=$this->createForm(new AlertType(),$alert);

        return $this->render('Trajet/Gerer/alert.html.twig', array(
            'form'=>$form->createView()
        ));
    }




    /**
     * @Route("/prix-optimal/{metre}", name="prix_optimal")
     */

    public function PrixOptimalAction($metre)
    {
        // 100 km => 5 TND

        $prix = 0;

        $em = $this->getDoctrine()->getManager();
        $PrixOptimel = $em->find('WanasniTrajetBundle:PrixOptimal', 1);

        if ($PrixOptimel) {
            $prix = $metre / $PrixOptimel->getX();
        }

        return new JsonResponse(array('PrixOptimal' => ceil($prix), 'Unite' => 'TND'));
    }

}
