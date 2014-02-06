<?php

namespace FSi\Bundle\AdminTreeBundle\Controller;

use Doctrine\ORM\EntityManager;
use FSi\Bundle\AdminBundle\Admin\Doctrine\CRUDElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;

class ReorderController
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function moveUpAction(Request $request, CRUDElement $element)
    {
        $entity = $this->getEntity($element, $request->get('id'));

        /** @var $repository \Gedmo\Tree\Entity\Repository\NestedTreeRepository */
        $repository = $element->getRepository();
        $repository->moveUp($entity);

        $om = $element->getObjectManager();
        $om->persist($entity);
        $om->flush();

        return new RedirectResponse(
            $this->router->generate('fsi_admin_crud_list', array('element' => $element->getId()))
        );
    }

    public function moveDownAction(Request $request, CRUDElement $element)
    {
        $entity = $this->getEntity($element, $request->get('id'));

        /** @var $repository \Gedmo\Tree\Entity\Repository\NestedTreeRepository */
        $repository = $element->getRepository();
        $repository->moveDown($entity);

        $om = $element->getObjectManager();
        $om->persist($entity);
        $om->flush();

        return new RedirectResponse(
            $this->router->generate('fsi_admin_crud_list', array('element' => $element->getId()))
        );
    }

    /**
     * @param \FSi\Bundle\AdminBundle\Admin\Doctrine\CRUDElement $element
     * @param int $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return Object
     */
    private function getEntity(CRUDElement $element, $id)
    {
        $entity = $element->getDataIndexer()->getData($id);

        if (!$entity) {
            throw new NotFoundHttpException();
        }

        return $entity;
    }
}
