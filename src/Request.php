<?php
namespace Payright;

use Laravie\Codex\Common\Response;
use Psr\Http\Message\ResponseInterface;

abstract class Request
{
    /**
     * @param ResponseInterface $message
     * @return Response
     */
    protected function responseWith(ResponseInterface $message)
    {
        return new Response($message);
    }

    /**
     * @return array
     */
    protected function getApiHeaders(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getApiBody(): array
    {
        return [];
    }

    /**
     * @param array $headers
     * @return array
     */
    final protected function mergeApiHeaders(array $headers = []): array
    {
        return array_merge($this->getApiHeaders(), $headers);
    }

    /**
     * @param array $body
     * @return array
     */
    final protected function mergeApiBody(array $body = []): array
    {
        return array_merge($this->getApiBody(), $body);
    }

}
