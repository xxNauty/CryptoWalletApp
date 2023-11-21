<?php

namespace App\Application\Inventory\Query\UserInventory;

use App\Domain\Shared\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;

class GetUserCurrencyQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Security $security
    ){
    }

    public function __invoke(GetUserCurrencyQuery $query): array
    {
        $inventory = $this->userRepository->find(
            $this->security->getUser()->id
        )->inventory;

        if(!array_key_exists($query->symbol, $inventory->content)){
            throw new NotFoundHttpException('You do not have this currency');
        }

        return [$query->symbol => $inventory->content[$query->symbol]];
    }
}
