<?php
namespace App\Controller;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @property EntityManagerInterface em
 */
class ArticlesController extends FOSRestController
{
    private $articleRepository;
    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }
    /**
     * @Rest\View(serializerGroups={"articles"})
     * @return \FOS\RestBundle\View\View
     */
    public function getArticlesAction()
    {
        $articles = $this->articleRepository->findAll();
        return $this->view($articles);
    }
    // "get_articles"            [GET] /articles
    /**
     * @Rest\View(serializerGroups={"articles"})
     */
    public function	getArticleAction($id)
    {
        $article = $this->articleRepository->find($id);
        return $this->view($article);
    }
    // "get_article"             [GET] /articles/{id}
    /**
     * @Rest\View(serializerGroups={"articles"})
     * @Rest\Post("/articles")
     * @ParamConverter("article", converter="fos_rest.request_body")
     */
    public function postArticlesAction(Article $article)
    {
        // recup user courant
        $user = $this->getUser();
        // associe l'user de l'article a l'utilsateu courant
        $article->setUser($user);

        $this->em->persist($article);
        $this->em->flush();
        return $this->view($article);
    }

    /**
     * @Rest\View(serializerGroups={"articles"})
     */
    public function putArticleAction(int $id, Request $request)
    {
        $title = $request->get('title');
        $content = $request->get('content');
        $article = $this->articleRepository->find($id);
        if ($article->getUser() == $this->getUser() or $this->isGranted('ROLE_ADMIN')) {
            if ($title) {
                $article->setTitle($title);
            }
            if ($content) {
                $article->setContent($content);
            }
        }
        $this->em->persist($article);
        $this->em->flush();
        return $this->view($article);
    }


    /**
     * @Rest\View(serializerGroups={"articles"})
     */
    public function	deleteArticleAction($id)
    {
        $article = $this->articleRepository->find($id);

        if ($article->getUser() == $this->getUser() or $this->isGranted('ROLE_ADMIN')) {

            $article->setUser(null);
            $this->em->remove($article);
            $this->em->flush();
        }
        else {
            return $this->view("NOOOOOO");
        }
    }

}