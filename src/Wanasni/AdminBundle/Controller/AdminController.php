<?php

namespace Wanasni\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Wanasni\PhotoBundle\Entity\Photo;

class AdminController extends Controller
{
    /**
     * @Route(path="/", name="admin_index")
     */
    public function indexAction()
    {
        return $this->render(':Admin:index.html.twig');
    }


    /**
     * @return Response
     * @Route(path="/show-photos-users", name="admin_show_photos_users")
     */
    public function showPhotosUserAction()
    {

        $rep=$this->getDoctrine()->getManager()->getRepository('WanasniPhotoBundle:Photo');

        $photos=$rep->getPhotosNotValid();

        return $this->render(':Admin:valid_photos.html.twig', array(
            'photos'=>$photos
        ));
    }


    /**
     * @param Photo $photo
     * @param Request $request
     * @return JsonResponse
     * @Route(path="/api-invalid-photo/{id}", name="api_admin_invalid_photo")
     * @ParamConverter("photo", class="WanasniPhotoBundle:Photo")
     */
    public function ApiInvalidPhoto(Photo $photo, Request$request)
    {

        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }


        $photo->removeUpload();
        $photo->setPath(null);
        $em=$this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();

        $message= \Swift_Message::newInstance();
        $message
            ->setFrom('app.wanasni@gmail.com','AdminWanasni')
            ->setTo($photo->getUser()->getEmail())
            ->setSubject('Votre photo a été refusée.')
            ->setBody(
                $this->renderView(':Admin:email_refuse_photo.html.twig',
                    array(
                        'photo'=>$photo
                    ))
            ,'text/html')

        ;

        $this->get('mailer')->send($message);






        return new JsonResponse(
            array(
                'error'=>array(
                    'code'=>200,
                    'message'=>'success'
                )
            ),200
        );
    }






    /**
     * @param Photo $photo
     * @param Request $request
     * @return JsonResponse
     * @Route(path="/api-valid-photo/{id}", name="api_admin_valid_photo")
     * @ParamConverter("photo", class="WanasniPhotoBundle:Photo")
     */
    public function ApivalidPhoto(Photo $photo, Request$request)
    {

        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }


        $photo->setValid(true);
        $em=$this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();


        $message= \Swift_Message::newInstance();
        $message
            ->setFrom('app.wanasni@gmail.com','AdminWanasni')
            ->setTo($photo->getUser()->getEmail())
            ->setSubject('Votre photo a été accepte.')
            ->setBody(
                $this->renderView(':Admin:email_accepte_photo.html.twig',
                    array(
                        'photo'=>$photo
                    ))
                ,'text/html')

        ;

        $this->get('mailer')->send($message);


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
