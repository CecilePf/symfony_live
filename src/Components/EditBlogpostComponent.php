<?php

namespace App\Components;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('edit_blogpost')]
final class EditBlogpostComponent extends AbstractController
{
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(exposed: ['title', 'content'], writable: true)]
    #[Assert\Valid]
    public Blog $blogpost;

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        $this->validate();
        $entityManager->flush();

        $this->addFlash('success', 'Article modifié !');

        return $this->redirectToRoute("app_blog");
    }
}
