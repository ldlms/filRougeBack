<?php

namespace App\Controller;

use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\LivreController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
use App\Repository\LivreRepository;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\Mapping\Id;
use App\Service\Utils;
use PhpParser\Node\Stmt\Nop;

class ApiNoteController extends AbstractController{
    #[Route('api/note/add', name:'app_api_note_add', methods:'POST')]
    public function addNote(Request $request, SerializerInterface $serialize, EntityManagerInterface $em, NoteRepository $repo,LivreRepository $repoBook,LivreController $con,):Response{
        try{    
        //récupérer le contenu de la requête JSON provenant du fron
            $json = $request->getContent();
            //test si on n'à pas de json
            if(!$json){
                //renvoyer un json
                return $this->json(['erreur'=>'Le Json est vide ou n\'existe pas'], 400, 
                ['Content-Type'=>'application/json',
                'Access-Control-Allow-Origin'=> 'localhost',
                'Access-Control-Allow-Methods'=> 'GET'],[]);
            }
            //sérializer le json en tableau
            $data = $serialize->decode($json, 'json');
            $note = new Note();
            //test si le livre existe déja
            $verifLivre = $repoBook->findOneBy(['idApi'=>$data['idApi']]);
            if($verifLivre){
                // $recup = $repo->findOneBy(['mail'=>$data['mail']]);
                // //test doublon d'une note pour l'utilisateur
                //     if($recup){
                //     //renvoyer un json
                //     return $this->json(['erreur'=>'Vous avez déja posté une note !'], 206, 
                //     ['Content-Type'=>'application/json',
                //     'Access-Control-Allow-Origin'=> '*',
                //     'Access-Control-Allow-Methods'=> 'GET'],[]);
                // }else{
                    //set des valeurs à l'objet
                    $note->setScore(Utils::cleanInputStatic($data['note']));
                    $note->setCritique(Utils::cleanInputStatic($data['critique']));
                    $note->setDate(new \DateTimeImmutable(Utils::cleanInputStatic($data['date'])));
                    $note->setLivre($verifLivre);
                    $em->persist($note);
                    $em->flush();

                    return $this->json(['erreur'=>'L\'article '.$note->getScore().' a été ajouté en BDD'], 200, 
                    ['Content-Type'=>'application/json',
                    'Access-Control-Allow-Origin'=> 'localhost',
                    'Access-Control-Allow-Methods'=> 'GET'],[]);
                }else{
                $note->setScore(Utils::cleanInputStatic($data['note']));
                $note->setCritique(Utils::cleanInputStatic($data['critique']));
                $note->setDate(new \DateTimeImmutable(Utils::cleanInputStatic($data['date'])));
                $em->persist($note);
                $em->flush();
                $book = $con->addLivre($data,$em,$note);
                    return $this->json(['erreur'=>'L\'article '.$note->getScore().' a été ajouté en BDD en plus du livre'], 200, 
                    ['Content-Type'=>'application/json',
                    'Access-Control-Allow-Origin'=> 'localhost',
                    'Access-Control-Allow-Methods'=> 'GET'],[]);
            }
        }catch(\Exception $e){
            return $this->json(['erreur'=>$e->getMessage()], 500, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> 'localhost',
            'Access-Control-Allow-Methods'=> 'GET'],[]);;
        }
    }
}

