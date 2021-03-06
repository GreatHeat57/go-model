<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Models\Traits;


trait FeaturedTrait
{
    public function getFeaturedHtml()
    {
        if (!isset($this->featured)) return false;
        return ajaxCheckboxDisplay($this->{$this->primaryKey}, $this->getTable(), 'featured', $this->featured);
    }
}