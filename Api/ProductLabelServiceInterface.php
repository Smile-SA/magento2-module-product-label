<?php
/**
 * Product Label Service interface
 *
 * @category  Smile
 * @package   Smile\ProductLabel
 * @author    Houda EL RHOZLANE <hoelr@smile.fr>
 * @copyright 2019 Smile
 */

namespace Smile\ProductLabel\Api;

interface ProductLabelServiceInterface
{
    /**
     * Set a list of product label Ids to be refreshed.
     *
     * @param array $productLabelIds The product label ids
     *
     * @return void
     */
    public function scheduleRefresh(array $productLabelIds);

    /**
     * Schedule appliance of product labels by attribute set ids.
     *
     * @param array $attributeSetIds A list of attribute set ids.
     *
     * @return mixed
     */
    public function scheduleRefreshByAttributeSetIds($attributeSetIds);

    /**
     * Process appliance of all product labels set to be refreshed.
     *
     * @return void
     */
    public function processRefresh();
}
