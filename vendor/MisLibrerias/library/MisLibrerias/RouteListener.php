<?php
namespace MisLibrerias;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

class RouteListener implements ListenerAggregateInterface
{
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $result = $events->attach(
            MvcEvent::EVENT_DISPATCH, array($this, 'algo'), 100
        );
    }

    public function algo(){

        //$this->layout()->setTemplate('layout/layout');
        echo  "<script>alert('onDispachtPlugin')</script>";

        //echo "ssssss";
        //$e->set

    }

    public function checkAcl(EventInterface $e)
    {
        $acl = $e->getApplication()->getServiceManager()
            ->get('User\Acl\Service');

        $routeMatch = $e->getRouteMatch();
        $response   = $e->getResponse();

        if (!$acl->isAllowed(
            $routeMatch->getParam('controller'),
            $routeMatch->getParam('action')
        )) {
            $routeMatch->setParam('controller', 'user');
            $routeMatch->setParam('action', 'forbidden');
        }
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        // TODO: Implement detach() method.
    }


}