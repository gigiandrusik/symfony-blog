<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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

    /**
     * @Route("/category/{id}/comment", name="category.comment")
     * @Method("POST")
     *
     * @param Request $request
     * @param Category $category
     *
     * @return JsonResponse
     */
    public function comment(Request $request, Category $category)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException('Bad Request');
        }

        $comment = new Comment();

        $comment->setCategory($category);
        $comment->setAuthor($request->get('author'));
        $comment->setContent($request->get('content'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($comment);
        $em->flush();

        return new JsonResponse([
            'author'  => $comment->getAuthor(),
            'content' => $comment->getContent(),
            'created' => $comment->getCreatedAt()->format('d-m-Y H:i:s'),
        ]);
    }
}