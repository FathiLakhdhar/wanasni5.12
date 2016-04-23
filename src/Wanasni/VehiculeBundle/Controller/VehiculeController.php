<?php

namespace Wanasni\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wanasni\VehiculeBundle\Entity\Marque;
use Wanasni\VehiculeBundle\Entity\Vehicule;
use Wanasni\VehiculeBundle\Form\VehiculeType;


class VehiculeController extends Controller
{


    /**
     * @Route("/vehicule", name="cars-show" )
     */
    public function ShowCarAction()
    {
        return $this->render(':Vehicule:voir_vehicules.html.twig');
    }


    /**
     * @Route("/vehicule-ajouter", name="car-add" )
     */
    public function AddCarAction()
    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->redirect($this->generateUrl('homepage'));
        }

        $car=new Vehicule();
        $m=new Marque();
        $em = $this->getDoctrine()->getManager();

        $form=$this->createForm(new VehiculeType($em,$m),$car);
        // On récupère la requête
        $request = $this->getRequest();


        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $car->setUser($this->getUser());
                $em->persist($car);
                $em->flush();

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Vehicule bien ajouté');

                return $this->redirect($this->generateUrl('car-add'));

            }

        }

        return $this->render(':Vehicule:car_add.html.twig', array(
            'form'=>$form->createView(),
        ));

    }


    /**
     * @Route("/car-models/{brand}", name="car-models" )
     */
    public function CarModelsAction($brand)
    {
        $arr_model = array();
        $em = $this->getDoctrine()->getManager();
        $repositoryMarque = $em->getRepository('WanasniVehiculeBundle:Marque');

        $marque = $repositoryMarque->findOneBy(array('carBrand' => strtoupper($brand)));

        if ($marque) {
        $modeles = $marque->getModeles();

            foreach ($modeles as $model) {
                $arr_model[] = array($model->getId() => $model->getCarModel()) ;
            }
        }
        return new JsonResponse($arr_model);
    }






}
