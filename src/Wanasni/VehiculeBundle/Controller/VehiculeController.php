<?php

namespace Wanasni\VehiculeBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $vehicules= $this->getUser()->getVehicules();

        return $this->render(':Vehicule:voir_vehicules.html.twig',array(
            'vehicules'=>$vehicules
        ));
    }


    /**
     * @Route("/vehicule-ajouter", name="car-add" )
     */
    public function AddCarAction()
    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }

        $car=new Vehicule();
        $form=$this->createForm(new VehiculeType(),$car);
        // On récupère la requête
        $request = $this->getRequest();


        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
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
     * @Route(path="/vehicule-supprimer/{id}", name="car_remove")
     */
    public function RemoveCarAction($id)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }


        $em=$this->getDoctrine()->getManager();
        $rep= $em->getRepository('WanasniVehiculeBundle:Vehicule');

        $car=$rep->findOneBy(array('id'=>$id,'user'=>$this->getUser()));

        if(!$car){
            throw new EntityNotFoundException();
        }

        if($car->getTrajets()->count()==0){
            $em->remove($car);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success','Véhicule bien supprimer');
        }else{

            $this->get('session')->getFlashBag()->set('info','Véhicule n\'est pas supprimer : cette véhicule utilisé dans un trajet');
        }

        return $this->redirect($this->generateUrl('cars-show'));


    }





    /**
     * @Route(path="/vehicule-modifier/{id}", name="car_edit")
     */
    public function EditCarAction($id,  Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw new AccessDeniedException();
        }


        $em=$this->getDoctrine()->getManager();
        $rep= $em->getRepository('WanasniVehiculeBundle:Vehicule');

        $car=$rep->findOneBy(array('id'=>$id,'user'=>$this->getUser()));

        if(!$car){
            throw new EntityNotFoundException();
        }


        $form= $this->createForm(new VehiculeType() , $car);


        if($request->getMethod()=="POST"){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $em->persist($car);
                $em->flush();
                $this->get('session')->getFlashBag()->set('success','Véhicule bien Modifier');
                return $this->redirect($this->generateUrl('cars-show'));
            }
        }


        return $this->render(':Vehicule:car_edit.html.twig',array(
            'form'=>$form->createView(),
            'id'=>$id
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
