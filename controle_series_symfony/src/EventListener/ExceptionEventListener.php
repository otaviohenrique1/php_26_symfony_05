<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[AsEventListener(event: 'kernel.exception')]
class ExceptionEventListener
{
  public function onKernelException(ExceptionEvent $event): void
  {
    // $errorMessage = $event->getThrowable()->getMessage();
    // $response = new Response();
    // $response->setContent($errorMessage);
    // $response->setStatusCode(501);
    // $event->setResponse($response);
    $error = $event->getThrowable();
    if (!$error instanceof NotFoundHttpException) {
      return;
    }

    $request = $event->getRequest();
    // $acceptLanguageHeader = $request->headers->get('Accept-Language');
    // $languages = explode(',', $acceptLanguageHeader);
    // $language = str_replace('-', '_', explode(';', $languages[0])[0]);
    $language = $request->getPreferredLanguage();

    // if (!str_starts_with($request->getPathInfo(), "/$language")) {
    if (!$this->startsWithValidLanguage($request)) {
      $response = new Response(302);
      $response->headers->add(['Location' => "/$language" . $request->getPathInfo()]);
      $event->setResponse($response);
    }
  }

  public function startsWithValidLanguage(Request $request): bool
  {
    $validLanguages = ['en', 'pt_BR'];
    foreach ($validLanguages as $language) {
      if (str_starts_with($request->getPathInfo(), "/$language")) {
        return true;
      }
    }

    return false;
  }
}
