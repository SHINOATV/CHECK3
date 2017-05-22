<?php

namespace TvShowManagerBundle\Controller;

use TvShowManagerBundle\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TvShowManagerBundle\Entity\TvShow;

/**
 * Episode controller.
 *
 * @Route("episode")
 */
class EpisodeController extends Controller
{


    /**
     * EpisodeController constructor.
     */
    public function __construct()
    {
    }

    public function LISTAction()
    {
        $em = $this->getDoctrine()->getManager();
        $episodes = $em->getRepository('TvShowManagerBundle:Episode')
            ->findBy(Episode::class, id)
            ->findBy(TvShow::class, id);

        return $this->render('@TvShowManager/Episode/list.html.twig', array('episodes' => $episodes,));
    }

    public function EDITAction(Request $request, $episodeId)
    {
        $em = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('TvShowManagerBundle:Episode')
            ->find($episodeId);
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('episodesList');
        }

        return $this->render('@TvShowManager/Episode/edit.html.twig', array('editForm' => $form->createView(),));
    }

    public function ADDAction(Request $request)
    {
        $episode = new Episode();
        $form = $this->createForm(EpisodeType::class, $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush();

            return $this->redirectToRoute('episodesList');
        }

        return $this->render('@TvShowManager/Episode/add.html.twig', array('addForm' => $form->createView(),));
    }

    public function DELAction(Request $request, $episodeId)
    {
        $em = $this->getDoctrine()->getManager();
        $episode = $em->getRepository('TvShowManagerBundle:Episode')
            ->find($episodeId);
        $em->remove($episode);
        $em->flush();

        return $this->render('@TvShowManager/Episode/del.html.twig', array('episode' => $episode,));
    }
}
