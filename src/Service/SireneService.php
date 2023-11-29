<?php

namespace App\Service;

use App\Entity\Company;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UnexpectedValueException;

class SireneService
{
    const SIRENE_API_URL = "https://api.insee.fr/entreprises/sirene/V3/";

    private Client $client;

    public function __construct($sireneToken)
    {
        $this->client = new Client([
            'base_uri' => self::SIRENE_API_URL,
            'headers' => [
                'Authorization' => "Bearer $sireneToken"
            ]
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function searchCompaniesByName(string $term, int $page, int $limit)
    {
        $term = mb_strtolower(htmlspecialchars($term));

        $response = $this->client->get('siret', [
            'query' => [
                'q' => 'raisonSociale:"' . $term . '"',
                'nombre' => $limit,
                'debut' => ($page - 1) * $limit
            ]
        ]);

        $results = json_decode($response->getBody()->getContents(), true);

        $this->checkResponse($results);

        return [
            'total' => $results['header']['total'] ?? 0,
            'companies' => $this->denormalizeCompanies($results['etablissements'])
        ];
    }

    /**
     * @throws GuzzleException
     */
    public function searchCompanyBySiret(string $siret): array
    {
        $siret = str_replace(" ", "", mb_strtolower(htmlspecialchars($siret)));

        $response = $this->client->get("siret/$siret");

        $results = json_decode($response->getBody()->getContents(), true);

        $this->checkResponse($results);

        return [
            'company' => $this->denormalizeCompany($results['etablissement'])
        ];
    }

    /**
     * @param array $datas
     * @return Company[]
     */
    public function denormalizeCompanies(array $datas): array
    {
        $companies = [];

        foreach ($datas as $data) {
            $companies[] = $this->denormalizeCompany($data);
        }

        return $companies;
    }

    public function denormalizeCompany(array $data)
    {
        $company = new Company();
        $company
            ->setSiren($data['siren'] ?? null)
            ->setSiret($data['siret'] ?? null)
            ->setCategory($data['uniteLegale']['categorieEntreprise'] ?? null)
            ->formatAddress(is_array($data['adresseEtablissement']) ? $data['adresseEtablissement'] : [])
            ->setCreatedAt(!empty($data['dateCreationEtablissement']) ? new \DateTime($data['dateCreationEtablissement']) : null);

        if(!empty($data['uniteLegale']['denominationUniteLegale'])) {
            $company->setName($data['uniteLegale']['denominationUniteLegale']);
        }
        elseif(!empty($data['uniteLegale']['nomUniteLegale'])) {
            $company->setName($data['uniteLegale']['nomUniteLegale']);
        }

        return $company;
    }

    public function checkResponse($response)
    {
        if(empty($response['header'])) {
            throw new BadRequestException("Une erreur est survenue");
        }

        if(!empty($response['header']['status']) && $response['header']['status'] == 404) {
            throw new NotFoundHttpException("Aucune entreprise n'a été trouvée");
        }
    }
}