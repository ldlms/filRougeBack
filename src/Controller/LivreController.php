<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class LivreController extends AbstractController
{
    public function addLivre($data,EntityManagerInterface $em){
        $book = new Livre();
        $book->setTitre(Utils::cleanInputStatic($data['titre']));
        $book->setDate(new \DateTimeImmutable(Utils::cleanInputStatic($data['date'])));
        $book->setidAPI(Utils::cleanInputStatic($data['idApi']));
        $book->setAuteur(Utils::cleanInputStatic($data['auteur']));

        $em->persist($book);
        $em->flush();

        return $book;
    }
}
