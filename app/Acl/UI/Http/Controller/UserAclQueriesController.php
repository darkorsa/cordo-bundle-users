<?php

declare(strict_types=1);

namespace App\Context\Acl\UI\Http\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cordo\Core\Application\Query\QueryFilter;
use Cordo\Core\UI\Http\Controller\BaseController;
use App\Context\Acl\UI\Transformer\AclTransformer;

class UserAclQueriesController extends BaseController
{
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $aclFilter = QueryFilter::fromQueryParams($queryParams);

        $service = $this->container->get('context.acl.query.service');

        $data = $this->transformerManager->transform($service->getCollection($aclFilter), 'context-acl');
        $data['total'] = $service->getCount($aclFilter);

        return $this->respondWithData($data);
    }

    public function getAction(ServerRequestInterface $request, $params): ResponseInterface
    {
        $service = $this->container->get('context.acl.query.service');

        $result = $service->getOneById($params['id']);

        return $this->respondWithData($this->transformerManager->transform($result, 'context-acl'));
    }

    protected function registerTransformers(): void
    {
        $this->transformerManager->add(new AclTransformer(), 'context-acl');
    }
}
