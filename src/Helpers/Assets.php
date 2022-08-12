<?php

namespace Dan\Shopify\Helpers;

use BadMethodCallException;
use Dan\Shopify\Models\AbstractModel;
use Dan\Shopify\Models\Asset;

/**
 * Class Assets.
 */
class Assets extends Endpoint
{
    /**
     * Get data using the `assets` endpoint.
     *
     * @param string $key
     *
     * @return array
     */
    public function get($key = null)
    {
        $query = is_null($key) ? $key : ['asset' => compact('key')];

        return $this->client->get($query);
    }

    /**
     * Post to a resource using the assigned endpoint ($this->endpoint).
     *
     * @param array|AbstractModel $payload
     * @param string              $append
     *
     * @throws BadMethodCallException
     *
     * @return array|AbstractModel
     */
    public function post($payload = [])
    {
        // Only PUT is allowed on `Asset`
        return $this->put($payload);
    }

    /**
     * Delete a resource using the assigned endpoint ($this->endpoint).
     *
     * @param string $key
     *
     * @return array
     */
    public function delete($key)
    {
        return $this->client->delete(['asset' => compact('key')]);
    }

    /**
     * @param $id
     *
     * @return Asset|null
     */
    public function find($id): ?Asset
    {
        $data = $data['asset'] ?? $this->get($id);

        if (empty($data)) {
            return null;
        }

        $model = new Asset($data);
        $model->exists = true;

        return $model;
    }

    /**
     * Return an array of models or Collection (if Laravel present).
     * @param string|array $keys
     * @todo
     * @return void
     */
    public function findMany($keys)
    {
        throw new BadMethodCallException('%s does not support findMany()', __CLASS__);
    }

    /**
     * PUT to `assets` endpoint using a `Asset` model.
     *
     * @param Asset $model
     *
     * @return Asset
     */
    public function save( $model)
    {
        $response = $this->request(
            $method = 'PUT',
            $uri = $this->uri(),
            $options = ['json' => $model->getPayload()]
        );

        $data = json_decode($response->getBody()->getContents(), true);

        if (isset($data[$model::$resource_name])) {
            $data = $data[$model::$resource_name];
        }

        $model->exists = true;
        $model->syncOriginal($data);

        return $model;
    }

    /**
     * @param Asset $model
     *
     * @return array
     */
    public function destroy(Asset $model)
    {
        return $this->delete($model->getKey());
    }
}
