<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class WordsController extends BaseController
{

    /**
     * @Route("/words/{type}", methods={"GET","HEAD"}, name="index")
     * @param string $type
     * @param Request $request
     * @return Response
     */
    public function index($type, Request $request, SessionInterface $session)
    {
        $filterNumber = $this->getCurrentFilter($request, $session);
        $filterList = $this->buildFilterList();
        $filter = null;
        if (array_key_exists($filterNumber, $filterList)) {
            $filter = $filterList[$filterNumber];
        }

        $types = $this->buildTypeList();
        if (!$request->get('type')) {
            throw new \RuntimeException('no type given');
        }
        $type = $request->get('type');
        if (!array_key_exists($type, $types)) {
            throw new \RuntimeException('unknown type "' . $type . '" given');
        }
        $file = $types[$type]['file'];

        $words = preg_split('/\n/', file_get_contents(__DIR__ . '/../../data/' . $file));
        if (isset($filter) && $filter['letters']) {
            $words = array_filter(
                $words,
                function ($word) use ($filter) {
#                    var_dump($filter);exit;
                    $pattern = '/^(\s|' . join('|', $filter['letters']) . ')+$/i';
#                    var_dump($pattern);exit;
                    return preg_match($pattern, $word);
                }
            );
        }
        sort($words);
        if (count($words) && $words[0] == '') {
            array_shift($words);
        }
        return $this->render('words.html.twig', [
                'words' => array_unique($words),
                'filter' => $filterNumber,
                'filters' => $filterList,
                'type' => $type,
                'types' => $types
            ]
        );
    }

}