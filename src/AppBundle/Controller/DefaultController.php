<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\ContactType;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("select p from AppBundle:Project p order by p.id desc")
                    ->setMaxResults(5);
        
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $request->getLocale() // take locale from session or request etc.
        );
        // fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1 // fallback to default values in case if record is not translated
        );
        
        $projects = $query->useResultCache(true, 360)->getResult();
        $response =  $this->render('default/index.html.twig', array(
            'activemenu' => 'home', 
            'projects' => $projects
        ));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }

    public function menuCategoriesAction(Request $request)
    {
        $categories = $this->retrieveCategories($request->getLocale());
        $response = $this->render('default/menuCategories.html.twig', array('categories' => $categories));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }

    public function aboutMeAction()
    {
        $response = $this->render('default/aboutme.html.twig');
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }

    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject($form->get('subject')->getData())
                ->setFrom($form->get('email')->getData())
                ->setTo('rsantellan@gmail.com')
                ->setBody(
                    $this->renderView(
                        'default/contactMessage.html.twig',
                        array(
                            'ip' => $request->getClientIp(),
                            'name' => $form->get('name')->getData(),
                            'message' => $form->get('message')->getData(),
                            'email' => $form->get('email')->getData(),
                            'subject' => $form->get('subject')->getData(),
                        )
                    )
                );
            $this->get('mailer')->send($message);
            $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');
            
        }
        return $this->render('default/contact.html.twig', array('form' => $form->createView()));
    }

    public function projectsShowAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository("AppBundle:Project")->findOneBySlug($slug);

        $imagesAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")
                        ->findOneBy(
                            array(
                                'object_id' => $project->getId(), 
                                'object_class' => $project->getFullClassName(), 
                                'name' => 'images'
                                )
                            );
        $mainAlbum = $em->getRepository("MaithCommonAdminBundle:mAlbum")
                        ->findOneBy(
                            array(
                                'object_id' => $project->getId(), 
                                'object_class' => $project->getFullClassName(), 
                                'name' => 'main'
                                )
                            );
        $response = $this->render('default/projectShow.html.twig', array(
                    'activemenu' => 'projects', 
                    'project' => $project, 
                    'imagesAlbum' => $imagesAlbum, 
                    'mainAlbums' => $mainAlbum
                    ));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }

    public function projectsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $this->retrieveCategories($request->getLocale(), $em);

        $query = $em->createQuery("select p, c from AppBundle:Project p join p.category c order by p.orden desc");

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $request->getLocale() // take locale from session or request etc.
        );
        // fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1 // fallback to default values in case if record is not translated
        );

        $projects = $query->useResultCache(true, 360)->getResult();
        $response =  $this->render('default/projectsThreeColumns.html.twig', array(
            'activemenu' => 'projects', 
            'projects' => $projects, 
            'categories' => $categories
            ));
        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }

    public function projectsCategoryAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")->findOneBySlug($slug);
        $dql = "select p, c from AppBundle:Project p join p.category c where c.id = :category order by p.orden desc";
        $query = $em->createQuery($dql)->setParameter('category', $category->getId());
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $request->getLocale() // take locale from session or request etc.
        );
        // fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1 // fallback to default values in case if record is not translated
        );
        $projects = $query->useResultCache(true, 360)->getResult();
        $response =  $this->render('default/projectsThreeColumns.html.twig', array(
            'activemenu' => 'projects', 
            'projects' => $projects, 
            'categories' => [],
            'page_title' => $category->getName(),
            'category' => $category
            ));

        $response->setPublic();
        $response->setSharedMaxAge("3600");
        return $response;
    }
    private function retrieveCategories($locale, $em = null)
    {
        if($em === null){
            $em = $this->getDoctrine()->getManager();    
        }
        $query = $em->createQuery("select c from AppBundle:Category c order by c.orden");
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale // take locale from session or request etc.
        );
        // fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1 // fallback to default values in case if record is not translated
        );
        return $query->useResultCache(true, 360)->getResult();
    }    
}
