<?php

namespace Spacestack\Rockly\Infrastructure\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Spacestack\Rockly\Infrastructure\DTO\DTO;
use Symfony\Component\Serializer\SerializerInterface;

class DTOParamConverter implements ParamConverterInterface
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        try {
            $dto = $this->serializer->deserialize(
                $request->getContent(),
                $configuration->getCLass(),
                'json'
            );
        } catch (\Throwable $e) {
            // TODO: HANLDING ERRORS
            throw $e;
        }

        $request->attributes->set($configuration->getName(), $dto);
    }

    public function supports(ParamConverter $configuration): bool
    {
        if (is_subclass_of($configuration->getClass(), Dto::class)) {
            return true;
        }
        
        return false;
    }
}