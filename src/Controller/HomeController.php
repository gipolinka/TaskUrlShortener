<?php


namespace App\Controller;



use Symfony\Component\HttpClient\HttpClient;
use App\Entity\LinkKey;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController

{

    const SERVICE_NAME='http://127.0.0.1:8000/';
        //"http://your.service";
    const SHORT_LINK_LENGTH=8;

    /**
     * @Route ("/")
     * @Route ("/service")
     */
    public function index(Request $request)
    {
        $linkKeyRaw = new LinkKey();
        $form = $this->createFormBuilder($linkKeyRaw)
            ->add('url_name', UrlType::class, ['label' => 'Your URL'])
            ->add('time_exp', DateType::class, ['label'=>'Link validity', 'data'=>new \DateTime()]// ,['widget'=>'text']
            )
            ->add('get', SubmitType::class, ['label' => 'Get short Link'])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid())
        {
            $linkKeyData=$form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $linkKeyRaw=$entityManager->getRepository(LinkKey::class)->findOneBy(["url_name"=>$linkKeyData->getUrlName()]);
            if($linkKeyRaw)
            {
                $shortUrl=$linkKeyRaw->getShortLink();
                $linkKeyRaw->setTimeExp($linkKeyData->getTimeExp());
                $numClick=$linkKeyRaw->getNumClick()??0;
            }
            else
            {
                $shortUrl=$this->shortLinkGenerate($linkKeyData->getUrlName());
                if(!$shortUrl)
                {
                    $shortUrl=$this->shortLinkGenerate($linkKeyData->getUrlName().$linkKeyData->getTimeExp()->format('Y-m-d'));
                }
                $linkKeyData->setShortLink($shortUrl);
                $linkKeyData->setNumClick(0);
                $entityManager->persist($linkKeyData);
            }
            $entityManager->flush();
        }
        return $this->render('homepage.html.twig',
            [
                "service_name" => self::SERVICE_NAME,
                "form" => $form->createView(),
                "short_url"=>$shortUrl??"",
                "num_click"=>$numClick??0
            ]);
    }

    public function shortLinkGenerate($linkValue)
    {
        $hashLink= md5($linkValue);
        $entityManager = $this->getDoctrine()->getManager();
        for($i=0; $i<=strlen($hashLink)-self::SHORT_LINK_LENGTH; $i++) {
                $linkKeyRaw = $entityManager->getRepository(LinkKey::class)
                    ->findOneBy(["short_link" => substr($hashLink, $i, self::SHORT_LINK_LENGTH)]);
            if (!$linkKeyRaw) {
                $shortLink = substr($hashLink, $i, self::SHORT_LINK_LENGTH);
                break;
            }
        }
        return $shortLink??null;
    }
}