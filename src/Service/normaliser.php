<?php
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntityNormalizer implements NormalizerInterface
{
    private $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $data = [];

        foreach ($object as $entity) {
            $normalizedEntity = [];
            
            // Accéder aux propriétés de l'entité en utilisant PropertyAccess
            $normalizedEntity['property1'] = $this->propertyAccessor->getValue($entity, 'property1');
            $normalizedEntity['property2'] = $this->propertyAccessor->getValue($entity, 'property2');
            // Ajoutez d'autres propriétés selon vos besoins

            $data[] = $normalizedEntity;
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null)
    {
        // Indiquer que le normalizer prend en charge le tableau d'entités
        return is_array($data) && !empty($data) && is_object($data[0]) && $data[0] instanceof YourEntityClassName;
    }
}

?>