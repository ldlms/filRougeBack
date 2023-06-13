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
use Symfony\component\Serializer\Serializer;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\PropertyAccess\PropertyAccess;
use App\Service\Utils;
use PhpParser\Node\Stmt\Nop;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ApiNoteController extends AbstractController{
    #[Route('api/note/add', name:'app_api_note_add', methods:'POST')]
    public function addNote(String $id,Request $request, SerializerInterface $serialize, EntityManagerInterface $em, NoteRepository $repo,LivreRepository $repoBook,LivreController $con,):Response{
        try{    
        //récupérer le contenu de la requête JSON provenant du fron
            $json = $request->getContent();
            //test si on n'à pas de json
            if(!$json){
                //renvoyer un json
                return $this->json(['erreur'=>'Le Json est vide ou n\'existe pas'], 400, 
                ['Content-Type'=>'application/json',
                'Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=> 'GET']);
            }
            //sérializer le json en tableau
            $data = $serialize->decode($json, 'json');
            $note = new Note();
            //test si le livre existe déja
            $verifLivre = $repoBook->findOneBy(['idApi'=>$data['idApi']]);
            if($verifLivre){
                    $note->setScore(Utils::cleanInputStatic($data['note']));
                    $note->setCritique(Utils::cleanInputStatic($data['critique']));
                    $note->setDate(new \DateTimeImmutable(Utils::cleanInputStatic($data['dateCritique'])));
                    $note->setTitreCritique(Utils::cleanInputStatic($data['titreCritique']));
                    $note->setLivre($verifLivre);
                    $em->persist($note);
                    $em->flush();
                    $notes = $repo->findBy(['livre'=>$verifLivre->getId()]);
                    return $this->json($notes, 200, 
                    ['Content-Type'=>'application/json',
                    'Access-Control-Allow-Origin'=> '*',
                    'Access-Control-Allow-Methods'=> 'GET'],['groups'=>'note:readAll']);
                }else{
                $book = $con->addLivre($data,$em);
                $note->setScore(Utils::cleanInputStatic($data['note']));
                $note->setCritique(Utils::cleanInputStatic($data['critique']));
                $note->setDate(new \DateTimeImmutable(Utils::cleanInputStatic($data['date'])));
                $note->setTitreCritique(Utils::cleanInputStatic($data['titreCritique']));
                $note->setLivre($book);
                $em->persist($note);
                $em->flush();
                $notes = $repo->findBy(['livre'=>$book->getId()]);
                return $this->json($notes, 200, 
                ['Content-Type'=>'application/json',
                'Access-Control-Allow-Origin'=> '*',
                'Access-Control-Allow-Methods'=> 'GET'],['groups'=>'note:readAll']);
            }
        }catch(\Exception $e){
            return $this->json(['erreur'=>$e->getMessage()], 500, 
            ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> '*',
            'Access-Control-Allow-Methods'=> 'GET','POST'],[]);;
        }
    }

    #[Route('/api/note/get/{id}', name:'app_api_note_all', methods:'GET')]
    public function getArticle(NoteRepository $repo, LivreRepository $repoBook,String $id):Response{
        $livre = $repoBook->findOneBy(['idApi'=>$id]);
        $notes = $repo->findBy(['livre'=>$livre->getId()]);
        if(empty($notes)){
            return $this->json(['erreur'=>'Il n\'y a pas d\'article'], 206, ['Content-Type'=>'application/json',
            'Access-Control-Allow-Origin'=> 'localhost',
            'Access-Control-Allow-Methods'=> 'GET']);
        }
        return $this->json($notes, 200, ['Content-Type'=>'application/json',
        'Access-Control-Allow-Origin'=> 'localhost',
        'Access-Control-Allow-Methods'=> 'GET'], ['groups'=>'note:readAll']);
    }
}

