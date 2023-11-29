<?php

namespace App\Controller;

use App\Service\SireneService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Twig\Environment;
use UnexpectedValueException;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    private TagAwareCacheInterface $cache;
    private SireneService $sireneService;
    private Environment $twig;

    public function __construct(TagAwareCacheInterface $cache, SireneService $sireneService, Environment $twig)
    {
        $this->cache = $cache;
        $this->sireneService = $sireneService;
        $this->twig = $twig;
    }

    /**
     * @Route("/search/{term}", name="search", methods={"GET"})
     *
     * @param $term
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function search($term, Request $request): JsonResponse
    {
        if(empty($term)) throw new UnexpectedValueException("Vous devez renseigner le nom d'une entreprise");

        $page = (int)$request->get('page', 1);
        $limit = (int)$request->get('limit', 10);

        $id_cache = "searchList[$term][$page][$limit]";

        $jsonResults = $this->cache->get($id_cache, function(ItemInterface $item) use ($term, $page, $limit) {
            $item->tag('searchList');
            $result = $this->sireneService->searchCompaniesByName($term, $page, $limit);

            $views = [
                'results__list' => $this->twig->render('api/company/list.html.twig', [
                    'companies' => $result['companies']
                ]),
                'results__count' => $this->twig->render('api/company/count.html.twig', [
                    'total' => $result['total']
                ]),
                'results__navigation' => $this->twig->render('api/company/navigation.html.twig', [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $result['total']
                ])
            ];

            return $views;
        });

        return new JsonResponse($jsonResults);
    }

    /**
     * @Route("/show/{siret}", name="show", methods={"GET"})
     *
     * @param $siret
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function show($siret): JsonResponse
    {
        if(empty($siret)) throw new UnexpectedValueException("Une erreur est survenue");

        $id_cache = "showDetails[$siret]";

        $jsonResults = $this->cache->get($id_cache, function(ItemInterface $item) use ($siret) {
            $item->tag('showDetails');
            $result = $this->sireneService->searchCompanyBySiret($siret);

            $views = [
                'modal__infos' => $this->twig->render('api/company/details.html.twig', [
                    'company' => $result['company']
                ])
            ];

            return $views;
        });

        return new JsonResponse($jsonResults);
    }
}
