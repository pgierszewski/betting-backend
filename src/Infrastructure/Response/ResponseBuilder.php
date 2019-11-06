<?php

namespace Spacestack\Rockly\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;
use Spacestack\Rockly\Infrastructure\DTO\DTO;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseBuilder
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function build($content, int $code = Response::HTTP_OK): Response
    {
        if ($content instanceof DTO) {
            $content = $this->serializer->serialize($content, 'json');
        }

        return new Response(
            $content,
            $code
        );
    }
}
