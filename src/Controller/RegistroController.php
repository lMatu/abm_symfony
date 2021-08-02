<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuarioType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(HttpFoundationRequest $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        $usuario = new Usuarios();
        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $en = $this->getDoctrine()->getManager();
            $usuario->setBaneado(false);
            $usuario->setRoles(['ROLE_USER']);
            $usuario->setFechaCreacion(new DateTime());
            $usuario->setPassword($passwordHasher->hashPassword($usuario, $form['password']->getData()));
            $en->persist($usuario);
            $en->flush();

            //Mensaje de Exito
            $this->addFlash('success', 'Registrado correctamente');

            return $this->redirectToRoute('registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView(),
        ]);
    }
}
