<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{
    /**
     * @Route("/", methods={"GET","HEAD"}, name="home")
     */
    public function index(Request $request, SessionInterface $session)
    {
        return $this->render('index.html.twig', [
                'files' => glob(__DIR__ . '/../../data/*txt'),
                'filter' => $this->getCurrentFilter($request, $session),
                'filters' => $this->buildFilterList(),
                'type' => null,
                'types' => $this->buildTypeList()
            ]
        );
    }
}