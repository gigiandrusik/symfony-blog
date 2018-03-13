<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CategoryController
 *
 * @package App\Controller
 */
class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="categories")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'categories' => $this->getDoctrine()->getRepository(Category::class)->findAll()
        ]);
    }

    /**
     * @Route("/category/{id}/show", name="category.show")
     *
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/category/create", name="category.create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'The category created successfully.');

            return $this->redirectToRoute('categories');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/{id}/edit", name="category.edit")
     *
     * @param Request $request
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash('info', 'The category updated successfully.');

            return $this->redirectToRoute('categories');
        }

        return $this->render('category/edit.html.twig', [
            'form'     => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * @Route("/category/{id}/delete", name="category.delete")
     * @Method("POST")
     *
     * @param Category $category
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($category);
        $em->flush();

        $this->addFlash('info', 'The category deleted successfully.');

        return $this->redirectToRoute('categories');
    }
}