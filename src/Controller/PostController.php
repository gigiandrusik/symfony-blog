<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PostController
 *
 * @package App\Controller
 */
class PostController extends Controller
{
    /**
     * @Route("/posts", name="posts")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('post/index.html.twig', [
            'posts' => $this->getDoctrine()->getRepository(Post::class)->findAll()
        ]);
    }

    /**
     * @Route("/post/create", name="post.create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'The post created successfully.');

            return $this->redirectToRoute('posts');
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}