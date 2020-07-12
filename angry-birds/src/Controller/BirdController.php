<?php

namespace App\Controller;

use App\Model\Bird;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BirdController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="birds")
     */
    public function index(Bird $bird)
    {

        $birdList = $bird->getBirds();

        $lastBirdSeen = $this->session->get('lastBirdSeen');
        $sessionId = $this->session->get('lastBirdSeenId');

        return $this->render('bird/index.html.twig', [
            'controller_name' => 'Alex',
            'birds' => $birdList,
            'session' => $lastBirdSeen,
            'sessionId' => $sessionId,

        ]);
    }

    /**
     * @Route("/bird/{id}", name="single", requirements={"id" : "\d+"})
     */
    public function single(Bird $bird, $id)
    {

        $singleBird = $bird->getSingleBird($id);

        if ($singleBird === null) {

            throw $this->createNotFoundException('L\'oiseau demandé n\'existe pas');

        } else {

            $this->session->set('lastBirdSeen', $singleBird);
            $this->session->set('lastBirdSeenId', $id);
            
        }

        return $this->render('bird/single.html.twig', [
            'singleBird' => $singleBird, 
        ]);
    }

    /**
     * @Route("/bird/download", name="bird_calendar")
     */
    public function download()
    {
        // send the file contents and force the browser to download it
        return $this->file(
            __DIR__ . '/../../public/file/angry_birds_2015_calendar.pdf',
            'calendrier.pdf',
            ResponseHeaderBag::DISPOSITION_INLINE
        );
    }


}
