<?php

namespace TvShowManagerBundle\Controller;

use TvShowManagerBundle\Entity\TvShow;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TvShowController extends Controller
{


    public function LISTAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tvShows = $em->getRepository('TvShowManagerBundle:TvShow')
            ->findAll();

        return $this->render('@TvShowManager/TvShow/list.html.twig', array('tvShows' => $tvShows,));
    }

    public function EDITAction(Request $request, $tvShowName)
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('TvShowManagerBundle:TvShow')
            ->findOneByName($tvShowName);
        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('tvShowsList');
        }

        return $this->render('@TvShowManager/TvShow/edit.html.twig', array('editForm' => $form->createView(),));
    }

    public function ADDAction(Request $request)
    {
        $tvShow = new TvShow();
        $form = $this->createForm(TvShowType::class, $tvShow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tvShow);
            $em->flush();

            return $this->redirectToRoute('tvShowsList');
        }

        return $this->render('@TvShowManager/TvShow/add.html.twig', array('addForm' => $form->createView(),));
    }

    public function DELAction(Request $request, $tvShowName)
    {
        $em = $this->getDoctrine()->getManager();
        $tvShow = $em->getRepository('TvShowManagerBundle:TvShow')
            ->findOneByName($tvShowName);
        $em->remove($tvShow);
        $em->flush();

        return $this->render('@TvShowManager/TvShow/del.html.twig', array('show' => $tvShow,));
    }
    public function NOTEAction()
    {
        $moyNotes=[];
        $em = $this->getDoctrine()->getManager();
        $tvShows = $em->getRepository('TvShowManagerBundle:TvShow')
            ->findAll();

        foreach ($tvShows as $show) {
            $sumNote = 0;

            foreach ($show->getEpisodes() as $episode) {
                $sumNote += $episode->getNote();
            }
                $moyNote = $sumNote / count($show->getEpisodes());
                $moyNotes[$show->getName()] = $moyNote;
        }

        arsort($moyNotes);

        return $this->render('@TvShowManager/TvShow/note.html.twig', array('moyNotes' => $moyNotes,));
    }
}
