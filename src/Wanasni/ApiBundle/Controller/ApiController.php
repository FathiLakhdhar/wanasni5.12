<?php

namespace Wanasni\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Wanasni\AdminBundle\Entity\Contact;
use Wanasni\UserBundle\Entity\User;

class ApiController extends Controller
{
    /**
     *
     * @return JsonResponse
     * @Route(path="/api/all-contacts", name="api_all_contacts")
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
     * @Route(path="/api/search/contacts", name="api_search_username")
     */
    public function ApiGetContactsByUsernameAction(Request $request)
    {

        $username= $request->query->get('q');

        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository('WanasniUserBundle:User');
        $Contacts=$rep->getUsersByUsername($username, $this->getUser());

        $arr=array();
        $total_count=0;
        foreach($Contacts as $Contact){


            $total_count++;
            $arr[]=array(
                'id'=>$Contact->getId(),
                'username'=>$Contact->getUsername(),
                'full_name'=>$Contact->getFullName(),
                'fistname'=>$Contact->getFirstname(),
                'lastname'=>$Contact->getLastname(),
                'minibio'=>($Contact->getMinibio()==null)? "":$Contact->getMinibio(),
                'icon'=> $this->container->get('templating.helper.assets')->getUrl($Contact->getPhoto()->getwebPath())
            );

        }

        return new JsonResponse(array(
            'total_count'=> $total_count,
            'items'=>$arr
        ));
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






    /**
     * @Route(path="/api/contactez-nous", name="api_contactez_nous")
     * @Method(methods={"POST"})
     */
    public function ContactezNousAction(Request $request)
    {



        $contact= new Contact();

        $contact->setNom($request->request->get('name'));
        $contact->setEmail($request->request->get('email'));
        $contact->setMessage($request->request->get('message'));

        $validator= $this->get('validator');

        $liste_erreurs = $validator->validate($contact);

        $arr_error=array();
        if(count($liste_erreurs) > 0) {
            foreach($liste_erreurs as $error){
                $arr_error[]=$error->getMessage();
            }
            return new JsonResponse(
                array(
                    'error'=>array(
                        'code'=>400,
                        'message'=>'erreur de saisir form contact',
                        'liste_erreurs'=>$arr_error
                    )
                ),400
            );
        }else{


            $em=$this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();


            return new JsonResponse(
                array(
                    'error'=>array(
                        'code'=>200,
                        'message'=>'success'
                    )
                ),200
            );
        }



    }


    
}
