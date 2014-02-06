<?php

namespace spec\FSi\Bundle\AdminTreeBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use FSi\Bundle\AdminBundle\Admin\Doctrine\CRUDElement;
use FSi\Component\DataIndexer\DoctrineDataIndexer;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

/**
 * @mixin \FSi\Bundle\AdminTreeBundle\Controller\ReorderController
 */
class ReorderControllerSpec extends ObjectBehavior
{
    function let(
        Router $router,
        CRUDElement $element,
        DoctrineDataIndexer $indexer,
        ObjectManager $om,
        NestedTreeRepository $repository
    ) {
        $element->getId()->willReturn('category');
        $element->getDataIndexer()->willReturn($indexer);
        $element->getObjectManager()->willReturn($om);
        $element->getRepository()->willReturn($repository);

        $this->beConstructedWith($router);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('FSi\Bundle\AdminTreeBundle\Controller\ReorderController');
    }

    function it_moves_up_item_when_move_up_action_called(
        CRUDElement $element,
        Request $request,
        NestedTreeRepository $repository,
        \StdClass $category,
        Request $request,
        ObjectManager $om,
        Router $router,
        DoctrineDataIndexer $indexer
    ) {
        $request->get('id')->willReturn(1);
        $indexer->getData(1)->willReturn($category);

        $repository->moveUp($category)->shouldBeCalled();

        $om->persist($category)->shouldBeCalled();
        $om->flush()->shouldBeCalled();

        $router->generate('fsi_admin_crud_list', Argument::withEntry('element', 'category'))
            ->willReturn('sample-path');

        $response = $this->moveUpAction($request, $element);
        $response->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
        $response->getTargetUrl()->shouldReturn('sample-path');
    }

    function it_moves_down_item_when_move_down_action_called(
        CRUDElement $element,
        Request $request,
        NestedTreeRepository $repository,
        \StdClass $category,
        Request $request,
        ObjectManager $om,
        Router $router,
        DoctrineDataIndexer $indexer
    ) {
        $request->get('id')->willReturn(1);
        $indexer->getData(1)->willReturn($category);

        $repository->moveDown($category)->shouldBeCalled();

        $om->persist($category)->shouldBeCalled();
        $om->flush()->shouldBeCalled();

        $router->generate('fsi_admin_crud_list', Argument::withEntry('element', 'category'))
            ->willReturn('sample-path');

        $response = $this->moveDownAction($request, $element);
        $response->shouldHaveType('Symfony\Component\HttpFoundation\RedirectResponse');
        $response->getTargetUrl()->shouldReturn('sample-path');
    }

    function it_throws_runtime_exception_when_specified_entity_doesnt_exist(
        CRUDElement $element,
        Request $request,
        DoctrineDataIndexer $indexer
    ) {
        $request->get('id')->willReturn(666);
        $indexer->getData(666)->willThrow('FSi\Component\DataIndexer\Exception\RuntimeException');

        $this->shouldThrow('FSi\Component\DataIndexer\Exception\RuntimeException')
            ->duringMoveUpAction($request, $element);

        $this->shouldThrow('FSi\Component\DataIndexer\Exception\RuntimeException')
            ->duringMoveDownAction($request, $element);
    }
}
