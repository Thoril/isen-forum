<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostController
 * @package AppBundle\Controller
 *
 * @Route("/forum/{forum_id}/topic/{topic_id}/post", requirements={"topic_id":"\d+"})
 */
class PostController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction(int $topic_id, Request $request)
    {
        $topic = $this->getDoctrine()->getRepository(Topic::class)->find($topic_id);
        $forum =$topic->getForum();

        if($request->isMethod('post')){
            $post = new Post();
            $post->setMessage($request->get('message'));
            $post->setAuthor($request->get('author'));
            $post->setCreation(new \DateTime());
            $post->setTopic($topic);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('app_topic_show',['id' => $topic->getId(), "forum_id"=> $forum->getId()]);
        }
        return $this->render('AppBundle:Post:add.html.twig', array(
            'topic'=>$topic
        ));


    }


}
