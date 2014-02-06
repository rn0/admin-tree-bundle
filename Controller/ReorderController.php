<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Bundle\AdminTreeBundle\Controller;

use FSi\Bundle\AdminBundle\Admin\Doctrine\CRUDElement;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;

class ReorderController
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param CRUDElement $element
     * @param $id
     * @return RedirectResponse
     */
    public function moveUpAction(CRUDElement $element, $id)
    {
        $entity = $this->getEntity($element, $id);

        /** @var $repository \Gedmo\Tree\Entity\Repository\NestedTreeRepository */
        $repository = $element->getRepository();
        $this->assertCorrectRepositoryType($repository);
        $repository->moveUp($entity);

        $om = $element->getObjectManager();
        $om->persist($entity);
        $om->flush();

        return new RedirectResponse(
            $this->router->generate('fsi_admin_crud_list', array('element' => $element->getId()))
        );
    }

    /**
     * @param CRUDElement $element
     * @param $id
     * @return RedirectResponse
     */
    public function moveDownAction(CRUDElement $element, $id)
    {
        $entity = $this->getEntity($element, $id);

        /** @var $repository \Gedmo\Tree\Entity\Repository\NestedTreeRepository */
        $repository = $element->getRepository();
        $this->assertCorrectRepositoryType($repository);
        $repository->moveDown($entity);

        $om = $element->getObjectManager();
        $om->persist($entity);
        $om->flush();

        return new RedirectResponse(
            $this->router->generate('fsi_admin_crud_list', array('element' => $element->getId()))
        );
    }

    /**
     * @param CRUDElement $element
     * @param int $id
     * @throws NotFoundHttpException
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

    /**
     * @param $repository
     * @throws \InvalidArgumentException
     * @internal param \FSi\Bundle\AdminBundle\Admin\Doctrine\CRUDElement $element
     */
    private function assertCorrectRepositoryType($repository)
    {
        if (!$repository instanceof NestedTreeRepository) {
            throw new \InvalidArgumentException(
                sprintf("Entity must have repository class 'NestedTreeRepository'")
            );
        }
    }
}
