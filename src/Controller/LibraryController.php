<?php

namespace App\Controller;


use App\Entity\BookList;
use App\Form\BookFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{

    /**
     * @Route("/", name="app_library")
     */
    public function showAllBook()
    {
        $books = $this->getDoctrine()->getRepository(BookList::class);
        $booksList = $books->findAll();

        return $this->render('library/lib.html.twig', [
            'title' => 'Список книг',
            'bookList' => $booksList,
        ]);
    }


    /**
     * @Route("/new", name="app_new")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(BookFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var BookList $book**/
            $book = $form->getData();

           $em->persist($book);
           $em->flush();

            $this->addFlash('success', 'Книга дабавлена');

            return $this->redirectToRoute('app_library');
        }

        return $this->render('library/new.html.twig',[
            'title' => 'Добавление книги',
            'bookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_editBook")
     * @param BookList $book
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editBook(BookList $book, EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var BookList $book**/
            $book = $form->getData();

            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Книга обновлена');

            return $this->redirectToRoute('app_editBook', [
                'id' => $book->getId(),
            ]);
        }

        return $this->render('library/edit.html.twig',[
            'title' => 'Редактирование книги',
            'bookForm' => $form->createView()
        ]);
    }


}