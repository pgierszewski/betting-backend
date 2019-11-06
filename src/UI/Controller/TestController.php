<?php

namespace Spacestack\Rockly\UI\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        return new Response('Penis w żopu');
    }
}