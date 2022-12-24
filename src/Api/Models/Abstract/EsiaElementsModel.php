<?php

namespace Pavelrockjob\Esia\Api\Models\Abstract;

use Pavelrockjob\Esia\Api\Models\EsiaElement;
use Pavelrockjob\Esia\EsiaApi;
use Pavelrockjob\Esia\Exceptions\EsiaProviderException;

class EsiaElementsModel
{
    protected array $elements = [];
    protected string $path;
    protected string $postfix;

    protected EsiaApi $esiaApi;

    public function __construct(EsiaApi $esiaApi, string $path)
    {
        $this->esiaApi = $esiaApi;
        $this->path = $path;
    }

    /**
     * @throws \Exception
     */
    public function get(): array
    {
        $endpoint = $this->esiaApi->getEndpoint($this->path, $this->postfix);

        $response = $this->esiaApi->httpClient->request('GET', $endpoint)->getBody();

        $json = json_decode($response, true);

        if (!isset($json['elements'])) {
            throw new EsiaProviderException('Get elements request error: elements is not set. Check scope.');
        }

        foreach ($json['elements'] as $element){
            $this->elements[] = new EsiaElement($this->esiaApi, $element);
        }


        return $this->elements;
    }


    /**
     * @throws \Exception
     */
    public function findElement(string $elementType) {
        if (count($this->elements) <= 0){
            $this->get();
        }


        foreach ($this->elements as $element){
            /**
             * @var $element EsiaElement
             */
            $object = $element->get();

            if ($object->getType() === $elementType){
                return $object;
            }
        }

        return null;
    }
}
