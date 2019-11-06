<?php

namespace Spacestack\Rockly\UI\Controller\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Domain\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Spacestack\Rockly\App\BalanceFactory;

class AuthController
{
    /**
     * @Route("/api/auth/register", methods={"POST"}, name="auth_register_post")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em,
        BalanceFactory $balanceFactory
    ) {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(
                'Invalid registration data',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $domain = explode('@', $data['email'])[1];
        
        if ($domain !== 'genesis.com.mt') {
            return new JsonResponse(
                'Register only with genesis.com.mt email',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($encoder->encodePassword(
            $user,
            $data['password']
        ));

        $em->persist($user);
        $em->flush();

        $balance = $balanceFactory->create($user);
 
        return new JsonResponse('User created', JsonResponse::HTTP_CREATED);
    }
}
