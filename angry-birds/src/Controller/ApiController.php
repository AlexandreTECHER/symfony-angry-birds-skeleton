<?php

namespace App\Controller;

use App\Model\Bird;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/{id}"), name="bird_api")
     */
    public function api(Bird $bird, int $id)
    {
        $birdApi = $bird->getSingleBird($id);


        if ($birdApi === null) {

            return $this->json(
                [
                    'error' => [
                        'statuc_code' => 404,
                        'message' => 'L\'oiseau demandé n\'existe pas'
                    ]
                ],
                404
            );
        }
        return $this->json($birdApi);
    }
}
