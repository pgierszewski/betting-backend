<?php

namespace Spacestack\Rockly\UI\Controller\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Spacestack\Rockly\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController
{
    /**
     * @Route("/auth/register", methods={"POST"}, name="auth_register_post")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em
    ) {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(
                'Invalid registration data',
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

        return new JsonResponse('User created');
    }
}