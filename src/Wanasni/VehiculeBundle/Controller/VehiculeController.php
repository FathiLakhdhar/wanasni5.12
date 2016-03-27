<?php

namespace Wanasni\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class VehiculeController extends Controller
{

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
                $arr_model[] = $model->getCarModel();
            }
        }
        return new JsonResponse($arr_model);
    }
}
