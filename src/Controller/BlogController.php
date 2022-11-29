<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(Blog $blogpost): Response
    {
        return $this->render('blog/edit.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }

    #[Route('/generate', name: 'app_generate')]
    public function generate(EntityManagerInterface $entityManagerInterface): Response
    {
        $faker = Factory::create('fr_FR');

        $blogpost = new Blog();

        $blogpost->setTitle($faker->sentence())
            ->setContent($faker->paragraph());

        $entityManagerInterface->persist($blogpost);
        $entityManagerInterface->flush();

        return $this->redirectToRoute('app_blog');
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete(Blog $blogpost): Response
    {
        return $this->render('blog/delete.html.twig', [
            'blogpost' => $blogpost,
        ]);
    }
}
