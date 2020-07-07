<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Preview\BulkExports;

use Twilio\ListResource;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 */
class ExportList extends ListResource {
    /**
     * Construct the ExportList
     * 
     * @param Version $version Version that contains the resource
     * @return ExportList
     */
    public function __construct(Version $version) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array();
    }

    /**
     * Constructs a ExportContext
     * 
     * @param string $resourceType The resource_type
     * @return ExportContext
     */
    public function getContext($resourceType) {
        return new ExportContext($this->version, $resourceType);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Preview.BulkExports.ExportList]';
    }
}