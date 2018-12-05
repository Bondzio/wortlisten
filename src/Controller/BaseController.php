<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BaseController extends AbstractController
{
    protected function getCurrentFilter(Request $request, SessionInterface $session)
    {
        $filter = 0;
        /*if ($request->get('filter') == '') {
            $filter = null;
            $session->remove('filter');
        } else*/if ($request->get('filter') !== null) {
            $filter = (int)$request->get('filter');
            $session->set('filter', $filter);
        } elseif ($session->has('filter')) {
            $filter = (int)$session->get('filter');
        }
        return $filter;
    }

    protected function buildFilterList()
    {
        // GSM-Fibel: M, A, I, O, P, T, L, H, F, U, R, N, S, E, D, K, Ei, W, Ch, G, Au, B, Sch, J, Z, Eu, ß, V, Ä, Ö, Ü, Äu, ck, Pf, C, Y, X, Qu
        $letters = [
            'M',
            'A',
            'I',
            'O',
            'P',
            'T',
            'L',
            'H',
            'F',
            'U',
            'R',
            'N',
            'S',
            'E',
            'D',
            'K',
            'Ei',
            'W',
            'Ch',
            'G',
            'Au',
            'B',
            'Sch',
            'J',
            'Z',
            'Eu',
            'ß',
            'V',
            'Ä',
            'Ö',
            'Ü',
            'Äu',
            'ck',
            'Pf',
            'C',
            'Y',
            'X',
            'Qu'
        ];
        $result = [
            [
                'label' => 'alle',
                'letters' => ''
            ]
        ];
        for ($x = 3; $x < count($letters); $x++) {
            $list = [];
            for ($y = 0; $y < $x; $y++) {
                $list[] = $letters[$y];
            }
            $result[] = [
                'label' => $x == 3 ?
                    join(
                        ' ,',
                        array_map(
                            function ($letter) {
                                return '"' . $letter . '"';
                            },
                            array_slice($letters, 0, 3)
                        )
                    ) :
                    sprintf('bis "%s"', $list[count($list) - 1]),
                'letters' => $list
            ];
        }
        return $result;
    }

    protected function buildTypeList()
    {
        $result = [];
        $result['verben'] = ['type' => 'verben', 'file' => 'verben.txt', 'label' => 'Verben'];
        $result['praepositionen'] = [
            'type' => 'praepositionen',
            'file' => 'praepositionen.txt',
            'label' => 'Präpositionen'
        ];
        $result['tiere'] = ['type' => 'tiere', 'file' => 'tiere.txt', 'label' => 'Tiere'];
        $result['instrumente'] = ['type' => 'instrumente', 'file' => 'instrumente.txt', 'label' => 'Instrumente'];
        $result['jahreszeiten'] = ['type' => 'jahreszeiten', 'file' => 'jahreszeiten.txt', 'label' => 'Jahreszeiten'];
        $result['orte'] = ['type' => 'orte', 'file' => 'orte.txt', 'label' => 'Orte'];
        $result['zuhause'] = ['type' => 'zuhause', 'file' => 'zuhause.txt', 'label' => 'zuhause'];
        $result['schule'] = ['type' => 'schule', 'file' => 'schule.txt', 'label' => 'in der Schule'];
        $result['zahlen'] = ['type' => 'zahlen', 'file' => 'zahlen.txt', 'label' => 'Zahlen'];
        $result['essen'] = ['type' => 'essen', 'file' => 'essen.txt', 'label' => 'Essen'];
        $result['pflanzen'] = ['type' => 'pflanzen', 'file' => 'pflanzen.txt', 'label' => 'Pflanzen'];
        $result['organe'] = ['type' => 'organe', 'file' => 'organe.txt', 'label' => 'Körper & Organe'];
        $result['kleidung'] = ['type' => 'kleidung', 'file' => 'kleidung.txt', 'label' => 'Kleidung'];
        $result['name'] = ['type' => 'name', 'file' => 'namen.txt', 'label' => 'Namen'];
        $result['weltall'] = ['type' => 'weltall', 'file' => 'weltall.txt', 'label' => 'Erde & Weltall'];
        $result['nomen'] = ['type' => 'nomen', 'file' => 'worte.txt', 'label' => 'restliche Worte'];
        return $result;
    }
}