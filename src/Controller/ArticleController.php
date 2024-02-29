<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articles): Response
    {
        $articles_tab = $articles->findAll();
        return $this->render('article/index.html.twig', [
            "articles" => $articles_tab,
        ]);
    }
    #[Route('/article/{id}', name: 'article_detail_by_id')]
    public function showDetails($id, ArticleRepository $articles): Response
    {
        $article = $articles->findOneBy(['id' => $id]);
        
        return $this->render('composants/article_details.html.twig', [
            "article" => $article
        ]);
    }
}
