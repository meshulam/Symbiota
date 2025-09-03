<?php

/**
 * Script to be invoked as a cron command: 'php /path/to/publish_dwca.php'.
 * Reads the global config value SCHEDULED_PUBLISH_COLLECTIONS
 * and generates a Darwin Core archive for each collection, signaling to GBIF
 * that the archive has been updated.
 * 
 */
$_SESSION = array();
$_SERVER['HTTPS'] = true;
$_SERVER['SERVER_PORT'] = 443;

include_once('../config/symbini.php');
include_once($SERVER_ROOT.'/config/dbconnection.php');
include_once($SERVER_ROOT . '/classes/DwcArchiverPublisher.php');
include_once($SERVER_ROOT . '/classes/OccurrenceCollectionProfile.php');

// override classes to allow us to set the log path as a parameter
class DwcArchiverScheduledPublisher extends DwcArchiverPublisher {
    public function __construct($logPath = null){
        parent::__construct();
        if ($logPath) {
            $this->setVerboseMode(1);
            $this->setLogFH($logPath);
        }
    }
}

class OccurrenceCollectionProfileCustom extends OccurrenceCollectionProfile {
    public function __construct($logPath = null){
        parent::__construct();
        if ($logPath) {
            $this->setVerboseMode(1);
            $this->setLogFH($logPath);
        }
    }
}

$logPath = $GLOBALS['SERVER_ROOT'] . (substr($GLOBALS['SERVER_ROOT'], -1) == '/' ? '' : '/') . "content/logs/publish_dwca_" . date('Y-m-d') . ".log";

$dwcaManager = new DwcArchiverScheduledPublisher($logPath);
$collManager = new OccurrenceCollectionProfileCustom($logPath);

$dwcaManager->setLimitToGuids(true);

function getCollids() {
    $collids = [];
    $conn =  MySQLiConnectionFactory::getCon('readonly');

    // $scheduledPublishColls = 'MIN-Algae,MIN-Bryophytes,MIN-Lichens';
    $scheduledPublishColls = GLOBALS['SCHEDULED_PUBLISH_COLLECTIONS'];

    $trimmed = str_replace(['"', "'", ' ', '(', ')'], '', $scheduledPublishColls);
    $collKeys = explode(',', $trimmed);
    if (empty($collKeys)) {
        return $collids;
    }

    $sql = 'SELECT collid FROM omcollections WHERE CONCAT_WS("-", institutioncode, collectioncode) IN ("' . implode('","', $collKeys) . '");';
    $rs = $conn->query($sql);
    while ($r = $rs->fetch_object()) {
        $collids[] = $r->collid;
    }
    return $collids;
}

$includeAttributes = 0;
$includeMatSample = 0;
$includeIdentifiers = 0;

$collids = getCollids();

foreach($collids as $id){
    echo date('Y-m-d h:i:s A') . ' Processing collid ' . $id . "\n";

    $dwcaManager->resetCollArr($id);
    if($includeAttributes){
        if($dwcaManager->hasAttributes($id)) $dwcaManager->setIncludeAttributes(1);
        else $dwcaManager->setIncludeAttributes(0);
    }
    if($includeMatSample){
        if($dwcaManager->hasMaterialSamples($id)) $dwcaManager->setIncludeMaterialSample(1);
        else $dwcaManager->setIncludeMaterialSample(0);
    }
    if($includeIdentifiers){
        if($dwcaManager->hasIdentifiers($id)) $dwcaManager->setIncludeIdentifiers(1);
        else $dwcaManager->setIncludeIdentifiers(0);
    }
    if($dwcaManager->createDwcArchive()){
        $dwcaManager->writeRssFile();
        $collManager->batchTriggerGBIFCrawl(array($id));
    }
}

echo date('Y-m-d h:i:s A') . "Batch process finished! \n";
