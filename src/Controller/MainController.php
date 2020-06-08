<?php

namespace App\Controller;

use App\DataReader\CsvDataReader;
use App\DataReader\JsonDataReader;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Main Controller.​​
 */
class MainController
{
    private CsvDataReader $csvDR;
    private JsonDataReader $jsonDR;
    private Environment $twig;

    /**
     * @param CsvDataReader $csvDR
     * @param JsonDataReader $jsonDR
     * @param Environment $twig
     */
    public function __construct(Environment $twig, CsvDataReader $csvDR, JsonDataReader $jsonDR)
    {
        $this->csvDR = $csvDR;
        $this->jsonDR = $jsonDR;
        $this->twig = $twig;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $csvData = (new CarRepository($this->csvDR))->getRange(100);
        $jsonData = (new CarRepository($this->jsonDR))->getRange(100);
        return $this->render('cars.html.twig', [
            'csv' => $csvData,
            'json' => $jsonData,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function show(Request $request): Response
    {
        if (($id = $request->get('id')) === null || ($type = $request->get('type')) === null) {
            return new Response(\sprintf('\'%s\' and \'%s\' must be defined', 'id', 'type'), Response::HTTP_BAD_REQUEST);
        }

        if ($type === 'csv') {
            $reader = $this->csvDR;
        } elseif ($type === 'json') {
            $reader = $this->jsonDR;
        } else {
            return new Response(\sprintf('\'%s\' reader is not defined', $type));
        }

        $entity = (new CarRepository($reader))->findById((int) $id);
        if ($entity === null) {
            return new Response(\sprintf('Entity of type \'%s\' with ID \'%d\' not found', $type, $id));
        }

        return $this->render('car.html.twig', ['item' => $entity]);
    }

    public function render(string $template, array $params = []): Response
    {
        try {
            $content = $this->twig->render($template, $params);
            return new Response($content, Response::HTTP_OK);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
