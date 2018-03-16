<?php

namespace App\EventListener;

use App\Entity\Statistic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class RequestListener
 *
 * @package App\EventListener
 */
class RequestListener
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * RequestListener constructor.
     *
     * @param SessionInterface $session
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$this->session->get('new_session')) {

            $this->session->set('new_session', true);

            $request = $event->getRequest();

            $statistic = new Statistic();

            $statistic->setIp($request->getClientIp());
            $statistic->setUserAgent($request->headers->get('User-Agent'));

            $this->entityManager->persist($statistic);
            $this->entityManager->flush();
        }
    }
}