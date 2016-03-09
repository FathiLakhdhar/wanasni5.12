<?php

namespace Wanasni\TrajetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TrajetController extends Controller
{
    /**
     * @Route("/proposer", name="trajet_proposer" )
     */
    public function ProposerAction()
    {
        return $this->render(':Trajet/Proposer:proposer.html.twig');
    }
}
