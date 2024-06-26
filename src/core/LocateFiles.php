<?php

namespace Staple;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocateFiles {

    private $options;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct( array $options ) {
        $this->options = $options;
    }

    /**
     * Locate files
     *
     * @return array
     */
    public function locate() {
        $iterator = new RecursiveDirectoryIterator($this->options['dir']);
        $foundFiles = new RecursiveIteratorIterator($iterator);
        $fileTypes = $this->options['fileTypes'] ?? null;

        foreach ( $foundFiles as $file ) {
            $fileParts = explode( '.', $file );
            $fileExt = array_pop( $fileParts );
            $fileSlug = strtolower( $fileExt );

            if ( $fileTypes && in_array( $fileSlug, $fileTypes) ) {
                $files[] = [
                    'inputFilePath' => $file->getPathName(),
                    'pathName' => str_replace($this->options['dir'] . '/', '', $file->getPathName()),
                    'fileName' => $file->getFileName()
                ];
            }
        }

        return $files ?? null;
    }

}