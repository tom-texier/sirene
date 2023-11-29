<?php

namespace App\EventSubscriber;

use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException) {
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];
        }
        elseif ($exception instanceof GuzzleException && $exception->getCode() == 404) {
            $data = [
                'status' => $exception->getCode(),
                'message' => "Aucune entreprise n'a été trouvée"
            ];
        }
        elseif ($exception instanceof GuzzleException) {
            $data = [
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
        else {
            $data = [
                'status' => 500,
                'message' => $exception->getMessage()
            ];
        }

        $event->setResponse(new JsonResponse($data, $data['status']));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}