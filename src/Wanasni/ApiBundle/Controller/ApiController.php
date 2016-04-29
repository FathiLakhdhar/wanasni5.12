<?php

namespace Wanasni\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
                'icon'=>$this->container->get('templating.helper.assets')->getUrl($Contact->getPhoto()->getwebPath())
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
                'icon'=> $this->container->get('templating.helper.assets')->getUrl($Contact->getPhoto()->getwebPath())
            );
        }

        return new JsonResponse($arr);
    }

    /**
     * @param $id
     * @param Request $request
     * @return string|JsonResponse
     * @Route(path="/api/tooltip-profile/{id}", name="api_tooltip_profile")
     */
    public function tooltipProfileAction($id, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'error' => array(
                    'code' => 400,
                    'message' => 'You can access this only using Ajax!'
                )
            ),
                400);
        }


        $user=$this->getDoctrine()->getManager()->find('WanasniUserBundle:User',$id);

        return new JsonResponse(
            $this->renderView('@FOSUser/Profile/tooltip_profil.html.twig',array(
                'user'=>$user
            ))
        );

    }


    
}
