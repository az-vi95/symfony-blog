<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 30/11/2018
 * Time: 14:54
 */

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package App\Controller\Admin
 *
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Category::class);
        //$categories = $repository->findAll();

        // Cest commme un findAll() avec un tri sur name:
        $categories = $repository->findBy([], ['name' => 'asc']);


        return $this->render(
            'admin/category/index.html.twig',
            [
                'categories' => $categories
            ]
        );

    }

    /**
     * @Route("/edition")
     */
    public function edit(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categorie = new Category();
        // création du formulaire lié à la catégorie
        $form = $this->createForm(CategoryType::class, $categorie);

        // le formulaire analyse la requete HTTP
        // et traite le formulaire s'il a été soumis
        $form->handleRequest($request);

        // si le formulaire a été envoyé
        if($form->isSubmitted()) {
            dump($categorie);

            // si les validations à partir des annotations
            // dans l'entité Category sont ok
            if($form->isValid()) {
                // enregistrement de la catégorie en bdd
                $em->persist($categorie);
                $em->flush();

                // message de confirmation
                $this->addFlash('success', 'La catégorie est enregistrée');
                // redirection vers la liste
                return $this->redirectToRoute('app_admin_category_index');
            }else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');

            }
        }

        return $this->render(
            'admin/category/edit.html.twig',
            [
                // passage du formulaire au template
                'form' =>$form->createView()
            ]
        );
    }
}