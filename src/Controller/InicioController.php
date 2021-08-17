<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InicioController extends AbstractController
{
    /**
     * @Route("/inicio", name="inicio")
     */
    public function index(): Response
    {
        $en = $this->getDoctrine()->getManager(); 

        //$posts = $en->getRepository(Posts::class)->findAll();
        //$posts = $en->getRepository(Posts::class)->findBy(['titulo' => 'Como ser tan facha']);

        $posts = $en->getRepository(Posts::class)->findAllPosts();

        return $this->render('inicio/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
