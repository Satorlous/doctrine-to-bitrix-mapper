<?php

namespace App\Pages\Home\Banners\Controller;

use App\Pages\Home\Banners\Service\BannerService;
use App\Shared\JWT\Glue;
use App\Shared\JWT\State;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/pages/home/banners',
    name: 'app_homepage_banners',
    methods: ['GET']
)]
class GetBannerForHomePageAction extends AbstractController
{
    public function __invoke(
        Request       $request,
        BannerService $bannerService
    ): JsonResponse {
        if (!empty($jwtToken = (string)$request->headers->get('glue'))) {
            try {
                $state = $this->getState($jwtToken);
            } catch (Exception $exception) {
                return $this->json([
                    'success' => false,
                    'errors'  => [
                        [
                            'message' => $exception->getMessage(),
                        ],
                    ],
                ], Response::HTTP_UNAUTHORIZED);
            }
            $data = $bannerService->setLocationId($state->getLocationId())->get();
        } else {
            $data = $bannerService->getFirst();
        }
        return $this->json([
            'success' => true,
            'data'    => [
                'banners' => $data
            ],
        ]);
    }

    private function getState(string $token): State
    {
        return (new Glue())->getState($token);
    }
}
