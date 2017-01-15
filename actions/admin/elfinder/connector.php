<?php

error_reporting(0);

// Enable FTP connector netmount
elFinder::$netDrivers['ftp'] = 'FTP';
// ===============================================

/**
 * # Dropbox volume driver need `composer require dropbox-php/dropbox-php:dev-master@dev`
 *  OR "dropbox-php's Dropbox" and "PHP OAuth extension" or "PEAR's HTTP_OAUTH package"
 * * dropbox-php: http://www.dropbox-php.com/
 * * PHP OAuth extension: http://pecl.php.net/package/oauth
 * * PEAR's HTTP_OAUTH package: http://pear.php.net/package/http_oauth
 *  * HTTP_OAUTH package require HTTP_Request2 and Net_URL2
 */
// // Required for Dropbox.com connector support
// // On composer
// GC\Model\elFinder::$netDrivers['dropbox'] = 'Dropbox';
// // OR on pear
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDropbox.class.php';

// // Dropbox driver need next two settings. You can get at https://www.dropbox.com/developers
// define('ELFINDER_DROPBOX_CONSUMERKEY',    '');
// define('ELFINDER_DROPBOX_CONSUMERSECRET', '');
// define('ELFINDER_DROPBOX_META_CACHE_PATH',''); // optional for `options['metaCachePath']`
// ===============================================

// // Required for Google Drive network mount
// // Installation by composer
// // `composer require nao-pon/flysystem-google-drive:~1.1 nao-pon/elfinder-flysystem-driver-ext`
// // Enable network mount
// GC\Model\elFinder::$netDrivers['googledrive'] = 'FlysystemGoogleDriveNetmount';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// ===============================================

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string    $attr attribute name (read|write|locked|hidden)
 * @param  string    $path file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume)
{
    if (strpos(basename($path), '.') === 0) {
        if ($attr == 'read') {
            return false;
        } elseif ($attr == 'write') {
            return false;
        }
        return true;
    }

    return null;
}

// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
$normalizer = new GC\Normalizer();

$opts = array(
    'debug' => true,
    'bind' => array(
        'upload.pre mkdir.pre mkfile.pre rename.pre archive.pre ls.pre' => array(
        	[$normalizer, 'cmdPreprocess']
        ),
        'upload.presave' => array(
        	[$normalizer, 'onUpLoadPreSave']
        )
    ),
    'roots' => array(
        array(
            'driver'        => 'LocalFileSystem',               // driver for accessing file system (REQUIRED)
            'path'          => WEB_PATH.'/data/uploads/',       // path to files (REQUIRED)
            'URL'           => GC\Url::root('/data/uploads/'),  // URL to files (REQUIRED)
            'uploadDeny'    => array('all'),                    // All Mimetypes not allowed to upload
                                                                // Mimetype `image` and `text/plain` allowed to upload
            'uploadAllow'   => array('image', 'text/plain', 'application/zip', 'application/rar', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            'uploadOrder'   => array('deny', 'allow'),          // allowed Mimetype `image` and `text/plain` only
            'accessControl' => 'access'  ,                      // disable and hide dot starting files (OPTIONAL)
        ),
    )
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
