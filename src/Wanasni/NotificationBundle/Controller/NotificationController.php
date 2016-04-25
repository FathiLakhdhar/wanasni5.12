<?php

namespace Wanasni\NotificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class NotificationController extends Controller
{


    /**
     * @return JsonResponse
     * @Route(path="/api/all", name="api_user_notif_all")
     */
    public function ApiNotificationAction()
    {

        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }


        $notifications=$this->getUser()->getNotifications();
        $arr_notif=array();
        foreach($notifications as $notif){
            $arr_notif[]=array(
                'id'=>$notif->getId(),
                'contenu'=>$notif->getContenu(),
                'notifAt'=>$notif->getNotifAt()->format("F jS \\a\\t g:ia"),
                'type'=>$notif->getType(),
                'isRead'=>$notif->getLu(),
            );
        }

        return new JsonResponse(
            array(
                'error'=>array('code'=>200,'message'=>'OK'),
                'notifications'=>$arr_notif
            ),200
        );
    }


    /**
     * @return JsonResponse
     * @Route(path="api/nb-unread-notifications", name="api_nb_unread_notifications")
     */
    public function ApiNotifUnreadAction()
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }

        $rep=$this->getDoctrine()->getManager()->getRepository('WanasniNotificationBundle:Notification');

        $NbUnreadNotifications=$rep->nbUnreadNotification($this->getUser());


        return new JsonResponse(array(
            'NbUnreadNotifications'=>$NbUnreadNotifications
        ));
    }


}
