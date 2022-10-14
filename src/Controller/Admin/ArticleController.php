<?php

namespace App\Controller\Admin;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Entity\ArticleOption;
use App\Form\ArticleEditType;
use App\Form\ArticleOptionType;
use App\Repository\ArticleOptionRepository;
use App\Repository\ArticleRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use function PHPUnit\Framework\fileExists;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("admin/article")
 */
class ArticleController extends AbstractController
{
    private $em;
    private $translator;
    private $parent_page = 'Produit';
    public function __construct(EntityManagerInterface $entityManagerInterface, TranslatorInterface $translatorInterface)
    {
        $this->em = $entityManagerInterface;
        $this->translator = $translatorInterface;
    }
    /**
     * @Route("/load", name="article_load", methods={"GET","POST"})
     */
    public function load(Request $request, ArticleRepository $articleRepository): Response
    {
        if ($request->request->get('load') == 'articles') {
            return new JsonResponse([
                'reponse' => true,
                'content' => $this->render('admin/article/_load_articles.html.twig', [
                    'articlesOn' => $articleRepository->findAllOn(),
                    'articlesOff' => $articleRepository->findAllOff(),
                    'articlesTop' => $articleRepository->findEtat('top'),
                ])->getContent()
            ]);
        }
        return new JsonResponse(['reponse' => false]);
    }
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(BrandRepository $brandRepository, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/article/index.html.twig', [
            'articlesOn' => $articleRepository->findAllOn(),
            'articlesOff' => $articleRepository->findAllOff(),
            'articlesTop' => $articleRepository->findEtat('top'),
            'parent_page' => $this->parent_page
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, TranslatorInterface $translator, BrandRepository $brandRepository): Response
    {
        $article = new Article();
        $article
            ->setCreatedAt(new DateTime())
            ->setEnabled(true);
        // ->setTitle('produit 1')->setDescription('produit 1 description')
        // ->setPrice('1500000')->setBuyingPrice('120000')->setQuantity(5)->setLabel('New');

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere les images transmise
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                //om gener un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //on copie le fichier dans le dosiier uploads
                $image->move($this->getParameter('article_images_directory'), $fichier);
                //on stocke l'image dans la base de donnees 
                $img = new Image();
                $img->setName($fichier);
                $article->addImage($img);
            }
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            } else {
                $article->setUpdatedAt(new \DateTime());
            }
            $article->setQtyReel($article->getQuantity());
            $idBrand = $request->request->get('brand');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $message = $translator->trans('Article cree');
            $this->addFlash('success', "L'article a été crée.");
            return $this->redirectToRoute('article_new_add_option', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'parent_page' => 'Produit'
        ]);
    }
    /**
     * @Route("/copy/{id}/new", name="article_new_copy", methods={"GET","POST"})
     */
    public function newCopy(Article $article): Response
    {
        $articleCopy = new Article();
        $articleCopy->setTitle($article->getTitle())
        ->setCreatedAt(new DateTime())
        ->setQtyReel(0)
        ->setQuantity(0)
        ->setStatus($article->getStatus())
        ->setBuyingPrice($article->getBuyingPrice())
        ->setEtat($article->getEtat())
        ->setLabel($article->getLabel())
        ->setReduction($article->getReduction())
        ->setPrice($article->getPrice())->setDescription($article->getDescription())
        ->setCategory($article->getCategory())->setBrand($article->getBrand());
        $articleCopy->setEnabled(false);
        foreach ($article->getOptions() as $item) {
            $articleCopy->addOption($item);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($articleCopy);
        $entityManager->flush();
        $this->addFlash('success', "L'article a été copié.");
        return $this->redirectToRoute('article_edit', ['id' => $articleCopy->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        //Desactive l'article en ajax
        if ($request->request->get('edit') == 'enabled_false') {
            $article->setEnabled(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return new JsonResponse(true);
        }
        //Active l'article en ajax
        if ($request->request->get('edit') == 'enabled_true') {
            $article->setEnabled(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return new JsonResponse(true);
        }
        $form = $this->createForm(ArticleEditType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere les images transmise
            $images = $form->get('images')->getData();

            foreach ($images as $image) {
                //om gener un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                //on copie le fichier dans le dosiier uploads
                $image->move(
                    $this->getParameter('article_images_directory'),
                    $fichier
                );
                //on stocke l'image dans la base de donnees 
                $img = new Image();
                $img->setName($fichier);
                $article->addImage($img);
            }
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            } else {
                $article->setUpdatedAt(new \DateTime());
            }
            $article->setQtyReel($article->getQuantity());
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', "L'article a été modifier avec succès");
            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'parent_page' => 'Produit'
        ]);
    }

    /**
     * @Route("/new/add-option/{id}", name="article_new_add_option", methods={"GET","POST"})
     */
    public function newOption(Article $article = null): Response
    {
        return $this->renderForm('admin/article/new_add_option.html.twig', [
            'article' => $article
        ]);
    }
    /**
     * @Route("/new/add-option-ajax", name="article_new_add_option_ajax", methods={"POST"})
     */
    public function newOptionAjax(ArticleRepository $articleRepository, ArticleOptionRepository $articleOptionRepository, Request $request): Response
    {
        $reponse = [
            'reponse' => false,
            'error' => 'Erreur : 500'
        ];

        $id_article = $request->request->get('id_article');
        $nom = $request->request->get('nom');
        $valeur = $request->request->get('valeur');
        $articleOption = new ArticleOption();
        $form = $this->createForm(ArticleOptionType::class, $articleOption);
        if ($nom && $valeur && $id_article) {
            $article = $articleRepository->find($id_article);
            if ($article) {
                $entityManager = $this->getDoctrine()->getManager();
                $articleOption->setArticle($article)->setTitle($nom)->setContent($valeur);
                if ($articleOptionRepository->findOneBy([
                    'title' => $articleOption->getTitle(),
                    'article' => $article->getId()
                ])) {
                    $reponse = [
                        'reponse' => false,
                        'error' => 'Cette valeur existe !'
                    ];
                    return new JsonResponse($reponse);
                }
                $entityManager->persist($articleOption);
                $entityManager->flush();
                $reponse = [
                    'reponse' => true,
                    'error' => 'Erreur: 500 ',
                    'id' => $articleOption->getId()
                ];
                return new JsonResponse($reponse);
            }
        }
        return new JsonResponse($reponse);
    }

    /**
     * @Route("/nouveau-produit", name="article_new_produit", methods={"GET","POST"})
     * @Route("/{id}/edit-produit", name="article_edit_produit", methods={"GET","POST"})
     */
    public function newProduit(): Response
    {
        return $this->renderForm('admin/article/lest.html.twig', []);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article, int $id): Response
    {
        if (!$article) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
            'parent_page' => 'Produit'
        ]);
    }


    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($article->getImages()->getValues() as $image) {
                $path = $this->getParameter('article_images_directory') . '/' . $image->getName();
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article supprimé');
        }

        return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/delete/image/{id}", name="article_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Image $image, Request $request)
    {
        $token = $request->request->get('_token');
        //om verifi si le token est valide 
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $token)) {
            $path = $this->getParameter('article_images_directory') . '/' . $image->getName();
            if (file_exists($path)) {
                unlink($path);
            }
            $this->em->remove($image);
            $this->em->flush();
            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token invalide'], 400);
        }
    }
}
