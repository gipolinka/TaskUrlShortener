<?php


namespace App\Controller;


use App\Entity\LinkKey;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{

    /**
     * @Route ("/{link}")
     */
    public function index($link)
    {
        $repository = $this->getDoctrine()->getRepository(LinkKey::class);
        $linkKey = $repository->findOneBy(["short_link"=>$link]);
        if($linkKey!=null)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $linkKeyUpdate = $entityManager->getRepository(LinkKey::class)->find($linkKey->getId());
            $linkKeyUpdate->setNumClick($linkKeyUpdate->getNumClick()+1);
            $entityManager->flush();
            return $this->redirect($linkKey->getUrlName());
        }
        return new Response("no records");
    }

}