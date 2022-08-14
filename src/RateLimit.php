<?php

namespace Dan\Shopify;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use Psr\Http\Message\MessageInterface;

/**
 * Class RateLimit
 */
class RateLimit implements JsonSerializable
{
    public const HEADER_CALL_LIMIT = 'X-Shopify-Shop-Api-Call-Limit';
    public const HEADER_RETRY_AFTER = 'Retry-After';

    /** @var int $calls */
    protected $calls = 0;

    /** @var int $cap */
    protected $cap = 40;

    /** @var int $retry_after */
    protected $retry_after = 0;

    /**
     * RateLimit constructor.
     *
     * @param  Response|null $response
     */
    public function __construct(?Response $response)
    {
        if ($response) {
            $call_limit = $response->header(static::HEADER_CALL_LIMIT) ?: '0/40';

            [$this->calls, $this->cap] = explode('/', $call_limit);

            $this->retry_after = $response->header(static::HEADER_RETRY_AFTER) ?: 0;
        }
    }

    /**
     * @return bool
     */
    public function accepts()
    {
        return $this->calls < $this->cap;
    }

    /**
     * @return int
     */
    public function calls()
    {
        return $this->calls;
    }

    /**
     * @param callable $exceeded
     * @param callable $remaining
     *
     * @return mixed|bool
     */
    public function exceeded(callable $exceeded = null, callable $remaining = null)
    {
        $state = $this->calls >= $this->cap;

        if ($state && $exceeded) {
            return $exceeded($this);
        }

        if (! $state && $remaining) {
            return $remaining($this);
        }

        return $state;
    }

    /**
     * @param callable $remaining
     * @param callable $exceeded
     *
     * @return mixed|bool
     */
    public function remaining(callable $remaining = null, callable $exceeded = null)
    {
        $state = ($this->cap - $this->calls) > 0;

        if ($state && $remaining) {
            return $remaining($this);
        }

        if (! $state && $exceeded) {
            return $exceeded($this);
        }

        return $state;
    }

    /**
     * @param callable $retry
     * @param callable $continue
     *
     * @return int
     */
    public function retryAfter(callable $retry = null, callable $continue = null)
    {
        $state = $this->retry_after;

        if ($state && $retry) {
            sleep($state);
            return $retry($this);
        }

        if (! $state && $continue) {
            return $continue($this);
        }

        return $state;
    }

    /**
     * @param mixed $on_this
     *
     * @return static|Shopify|mixed
     */
    public function wait($on_this = null)
    {
        if ($this->exceeded()) {
            sleep($this->retryAfter());
        }

        return $on_this ?: $this;
    }

    /**
     * @return array
     */
    #[ArrayShape(['calls' => "mixed", 'cap' => "mixed", 'retry_after' => "mixed"])] public function jsonSerialize()
    {
        return [
            'calls' => $this->calls,
            'cap' => $this->cap,
            'retry_after' => $this->retry_after,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
