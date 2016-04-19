<?php

namespace Wanasni\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Wanasni\UserBundle\Entity\User;

class ApiController extends Controller
{
    /**
     *
     * @return JsonResponse
     * @Route(path="/api/contacts", name="api_contacts")
     */
    public function ApiGetContactsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Contacts=$em->getRepository('WanasniUserBundle:User')->findAll();
        $arr=array();
        foreach($Contacts as $Contact){
            $arr[]=array(
                'username'=>$Contact->getUsername(),
                'fistname'=>$Contact->getFirstname(),
                'lastname'=>$Contact->getLastname(),
                'icon'=>'imglksjqlkdj.jpeg'
            );
        }
        return new JsonResponse($arr);
    }


    /**
     * @param $username
     * @return JsonResponse
     * @Route(path="/api/contacts/{username}", name="api_contacts_by_username")
     */
    public function ApiGetContactsByUsernameAction($username)
    {
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository('WanasniUserBundle:User');
        $Contacts=$rep->getUsersByUsername($username);

        $arr=array();
        foreach($Contacts as $Contact){
            $arr[]=array(
                'username'=>$Contact->getUsername(),
                'fistname'=>$Contact->getFirstname(),
                'lastname'=>$Contact->getLastname(),
                'icon'=>'http://angola24horas.com/dist/img/avatar5.png'
            );
        }

        return new JsonResponse($arr);
    }
    
}
