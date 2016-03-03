<?php
namespace Ttree\EmailProviderDetector\Service;

/*
 * This file is part of the Ttree.EmailProviderDetector package.
 */

use TYPO3\Flow\Annotations as Flow;

/**
 * Detector Service
 *
 * @Flow\Scope("singleton")
 */
class DetectorService
{
    /**
     * @Flow\Inject(setting="source", package="Ttree.EmailProviderDetector")
     * @var string
     */
    protected $source;

    /**
     * @param string $emailAddress
     * @return boolean
     */
    public function isPublicProvider($emailAddress)
    {
        $source = $this->loadSource();
        $emailAddress = explode('@', $emailAddress);
        return in_array($emailAddress[1], $source);
    }

    /**
     * @return array
     */
    protected function loadSource()
    {
        $source = file($this->source);
        array_walk($source, function(&$element) {
            $element = preg_replace('/\s*$^\s*/m', '', trim($element));
        });
        return $source;
    }
}
