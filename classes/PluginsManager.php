<?php
include_once($SERVER_ROOT . '/classes/Manager.php');
include_once($SERVER_ROOT . '/classes/ImageShared.php');
include_once($SERVER_ROOT . '/classes/utilities/GeneralUtil.php');

class PluginsManager extends Manager {

 	public function __construct(){
 	}

 	public function __destruct(){
	}

	// mbaenrm: hardcoded Image ID slideshow
	public function createImageIDSlideShow($ids, $width, $interval) {
		if($width > 800) $width = 800;
		if($width < 275) $width = 275;

		$files = $this->fetchImagesByIds($ids);

		$showHtml = $this->getSlideshowStyle($width);
		$showHtml .= '<div id="slideshowcontainer">';
		$showHtml .= '<div class="container">';
		$showHtml .= '<div id="slides">';
		$showHtml .= $this->getImageHtmlByIds($files);
		$showHtml .= '</div></div></div>';
		$showHtml .= $this->getSlideshowScript($width,$interval);
		return $showHtml;
	}

	private function fetchImagesByIds($ids)
	{
		$files = Array();
		$parameters = str_repeat('?,', count($ids) - 1) . '?'; // placeholders 
		$sql = 'SELECT i.imgid, i.tid, i.occid, i.url, t.sciname, '.
			'CONCAT_WS("; ",o.sciname, o.catalognumber, CONCAT_WS(" ",o.recordedby,IFNULL(o.recordnumber,o.eventdate))) AS identifier '.
			'FROM images i '.
			'LEFT JOIN omoccurrences o ON i.occid = o.occid '.
			'LEFT JOIN taxa t ON i.tid = t.tid '.
			'WHERE i.imgid IN('.$parameters.') '.
			'ORDER BY FIELD(i.imgid,'.$parameters.') LIMIT 50';
		
		$conn = MySQLiConnectionFactory::getCon("readonly");
		$result = $conn->execute_query($sql, array_merge($ids, $ids));
		foreach ($result as $row) {
			$files[] = $row;
		}
		return $files;
	}

	private function getImageHtmlByIds($imageArr) {
		$html = '';
		foreach($imageArr as $imgIdArr){
			$linkUrl = $GLOBALS['CLIENT_ROOT'];
			if($imgIdArr["tid"]) $linkUrl .= '/taxa/index.php?taxauthid=1&tid='. $imgIdArr['tid'];

			$html .= '<div class="slideshowDiv">
				<div class="slideshowImageDiv">
					<a href="'.$linkUrl.'">
						<img src="'.$imgIdArr["url"].'" alt="'.$imgIdArr["sciname"].'">
					</a>
				</div>';
			$html .= '<div class="slideshowBaseDiv">
				<div class="slideshowCaptionDiv">';
			$html .= '<div class="slideshowCitationDiv">';
			if($imgIdArr["sciname"] || $imgIdArr["identifier"]){
				$html .= '<a href="' . htmlspecialchars($linkUrl, ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '" target="_blank">' . htmlspecialchars(($imgIdArr["sciname"]), ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '</a> ';
			}
			$html .= "</div></div>\n";
			$html .= "</div></div>\n";
		}
		return $html;
	}

	public function createSlideShow($ssid, $numSlides, $width, $numDays, $imageType, $clid, $dayInterval, $interval=7000){
		if($width > 800) $width = 800;
		if($width < 275) $width = 275;
		$this->initiateSlideShow($ssid,$numSlides,$numDays,$imageType,$clid,$dayInterval);
		$showHtml = $this->getSlideshowStyle($width);
		$showHtml .= '<div id="slideshowcontainer">';
		$showHtml .= '<div class="container">';
		$showHtml .= '<div id="slides">';
		$showHtml .= $this->getImageList($ssid);
		$showHtml .= '</div></div></div>';
		$showHtml .= $this->getSlideshowScript($width,$interval);
		return $showHtml;
	}

	public function initiateSlideShow($ssid,$numSlides,$numDays,$imageType,$clid,$dayInterval){
		global $SERVER_ROOT;
		$previousFile = $SERVER_ROOT.'/temp/slideshow/'.$ssid.'_previous.json';
		$infoFile = $SERVER_ROOT.'/temp/slideshow/'.$ssid.'_info.json';
		$currentDate = date("Y-m-d");
		$replace = false;
		$lastCLID = '';
		if(file_exists($infoFile)){
			$oldArr = json_decode(file_get_contents($infoFile), true);
			$lastCLID = $oldArr['clid'];
			$replaceDate = date('Y-m-d', strtotime($oldArr['lastDate']. ' + '.$dayInterval.' days'));
			if($currentDate > $replaceDate) $replace = true;
			elseif($clid != $lastCLID) $replace = true;
			elseif($numSlides != $oldArr['numslides']) $replace = true;
			elseif($numDays != $oldArr['numdays']) $replace = true;
			elseif($imageType != $oldArr['imagetype']) $replace = true;
		}
		else{
			$replace = true;
		}

		if($replace){
			ini_set('max_execution_time', 180); //180 seconds = 3 minutes
			$sinceDate = date('Y-m-d', strtotime($currentDate. ' - '.$numDays.' days'));

			$previousArr = Array();
			if($clid){
				if(file_exists($previousFile)){
					$previousArr = json_decode(file_get_contents($previousFile), true);
					unlink($previousFile);
					if($clid != $lastCLID){
						unset($previousArr);
						$previousArr = Array();
					}
				}
			}
			else{
				if(file_exists($previousFile)){
					unlink($previousFile);
				}
			}
			if(file_exists($infoFile)){
				unlink($infoFile);
			}

			//Create new files
			$ssIdInfo = array();
			$ssIdInfo['lastDate'] = $currentDate;
			$ssIdInfo['clid'] = $clid;
			if($numSlides > 10){
				$numSlides = 10;
			}
			if($numSlides < 5){
				$numSlides = 5;
			}
			$ssIdInfo['numslides'] = $numSlides;
			$ssIdInfo['numdays'] = $numDays;
			$ssIdInfo['imagetype'] = $imageType;

			$files = Array();
			$sql = 'SELECT m.mediaID, m.tid, m.occid, m.url, m.creator, m.`owner`, t.sciname, o.sciname AS occsciname, '.
				'CONCAT_WS(" ",u.firstname,u.lastname) AS creatorName, '.
				'CONCAT_WS("; ",o.sciname, o.catalognumber, CONCAT_WS(" ",o.recordedby,IFNULL(o.recordnumber,o.eventdate))) AS identifier '.
				'FROM media m LEFT JOIN users u ON m.creatorUid = u.uid '.
				'LEFT JOIN omoccurrences o ON m.occid = o.occid '.
				'LEFT JOIN taxa t ON m.tid = t.tid ';
			if($clid){
				$sql .= 'INNER JOIN fmchklsttaxalink cl ON m.tid = cl.tid WHERE cl.clid IN('.$clid.') ';
			}
			else{
				$sql .= 'WHERE m.InitialTimeStamp < "'.$sinceDate.'" AND m.tid IS NOT NULL ';
			}
			$sql .= 'AND m.sortsequence < 500 ';
			if($imageType == 'specimen'){
				$sql .= 'AND m.occid IS NOT NULL ';
			}
			elseif($imageType == 'field'){
				$sql .= 'AND m.occid IS NULL ';
			}
			$sql .= 'ORDER BY m.sortsequence LIMIT 200 ';
			//echo '<div>'.$sql.'</div>';
			//Set local domain
			$localDomain = GeneralUtil::getDomain();
			//Get records
			$cnt = 1;
 			$conn = MySQLiConnectionFactory::getCon("readonly");
			$rs = $conn->query($sql);
			while(($row = $rs->fetch_object()) && ($cnt < ($numSlides + 1))){
				$file = $row->url;
				if (substr($row->url, 0, 1) == '/'){
					//If imageDomain variable is set within symbini file, image
					if(!empty($GLOBALS['MEDIA_DOMAIN'])) $file = $GLOBALS['MEDIA_DOMAIN'] . $row->url;
					else $file = $localDomain.$row->url;
				}

				if($size = ImageShared::getImgDim(str_replace(' ', '%20', $file))){
					$width = $size[0];
					$height = $size[1];
					$files[$row->mediaID]['url'] = $file;
					$files[$row->mediaID]['width'] = $width;
					$files[$row->mediaID]['height'] = $height;
					$files[$row->mediaID]['tid'] = $row->tid;
					$files[$row->mediaID]['occid'] = $row->occid;
					$files[$row->mediaID]['creator'] = $row->creator;
					$files[$row->mediaID]['owner'] = $row->owner;
					$files[$row->mediaID]['sciname'] = $row->sciname;
					$files[$row->mediaID]['occsciname'] = $row->occsciname;
					$files[$row->mediaID]['creatorName'] = $row->creatorName;
					$files[$row->mediaID]['identifier'] = $row->identifier;
					$cnt++;
				}
			}
			$rs->free();
			$conn->close();

			//Remove previous slideshow images, unless there are less than 10 images available
			$reducedFileArr = array_diff_key($files, array_flip($previousArr));
			if(count($reducedFileArr) > 10){
				$previousArr = array_merge($previousArr,array_keys($files));
				$files = $reducedFileArr;
			}
			else{
				@unlink($previousFile);
				unset($previousArr);
				$previousArr = array();
			}
			$ssIdInfo['files'] = $files;

			//Save data to slideshow history/configuration files
			if($clid){
				$fp = fopen($previousFile, 'w');
				fwrite($fp, json_encode($previousArr));
				fclose($fp);
			}
			$fp = fopen($infoFile, 'w');
			fwrite($fp, json_encode($ssIdInfo));
			fclose($fp);
		}
	}

	public function getSlideshowStyle($width){
		$html = '<link rel="stylesheet" href="' . htmlspecialchars($GLOBALS['CLIENT_ROOT'], ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '/css/slideshowstyle.css">
			<style>
				a.slidesjs-next,
				a.slidesjs-previous,
				a.slidesjs-play,
				a.slidesjs-stop {
					transition: none;
					background-image: url('.$GLOBALS['CLIENT_ROOT'].'/images/css/images/btns-next-prev.png); background-repeat: no-repeat;
				}
				.slidesjs-pagination li a {
					transition: none;
					background-image: url('.$GLOBALS['CLIENT_ROOT'].'/images/css/images/pagination.png); background-position: 0 0;
				}
				#slideshowcontainer{
					clear:both; width:'.$width.'px; height:'.($width + 75).'px; 
				}
				.slideshowDiv{
					width:'.$width.'px; height:'.($width+50).'px;position:relative; 
				}
				.slideshowImageDiv{
					width:'.$width.'px; max-height:'.($width+50).'px; overflow:hidden; 
				}
				.slideshowImageDiv img{ position: absolute; top: -9999px; bottom: -9999px; left: -9999px; right: -9999px; margin: auto; max-width:'.$width.'px; max-height:'.($width+50).'px; }
				.slideshowBaseDiv{
					width:'.$width.'px; 
					position:absolute; 
					bottom:0; 
					background-color:rgba(255,255,255,0.8); 
					}
				.slideshowCitationDiv { 
					clear: both;
					text-align: center;
				}
				.slideshowHideLink{ font-size:9px; text-decoration:none; float:right; clear:both; margin-right:5px; }
				.slideshowShowLink{ font-size:9px; text-decoration:none; float:right; clear:both; margin-right:5px; display:none; }
			</style>';
		return $html;
	}

	public function getSlideshowScript($width,$interval){
		$html = '<script type="text/javascript">
				$(function() {
					$("#slides").slidesjs({
								width: '.$width.',
								height: '.($width + 50).',
								play: {
									active: true,
									auto: true,
									interval: '.$interval.',
									swap: true
								}
					});
				});
			</script>';
		return $html;
	}

	public function getImageList($ssid){
		global $LANG;
		$infoArr = json_decode(file_get_contents($GLOBALS['SERVER_ROOT'].'/temp/slideshow/'.$ssid.'_info.json'), true);
		//echo json_encode($infoArr);
		$imageArr = $infoArr['files'];
		$html = '';
		foreach($imageArr as $imgId => $imgIdArr){
			$linkUrl = $GLOBALS['CLIENT_ROOT'];
			if($imgIdArr['occid']) $linkUrl .= '/collections/individual/index.php?occid='.$imgIdArr['occid'].'&clid=0';
			elseif($imgIdArr["tid"]) $linkUrl .= '/taxa/index.php?taxon='.str_replace(' ','%20',$imgIdArr['sciname']);

			$html .= '<div class="slideshowDiv">
				<div class="slideshowImageDiv">
					<a href="'.$linkUrl.'" target="_blank">
						<img src="'.$imgIdArr["url"].'" alt="'.($imgIdArr["occsciname"]?$imgIdArr["occsciname"]:$imgIdArr["sciname"]).'">
					</a>
				</div>';
			$hideCaptionClick = "$('.slideshowCaptionDiv').hide();$('.slideshowShowLink').show();return false;";
			$html .= '<div class="slideshowBaseDiv">
				<div class="slideshowCaptionDiv">
					<a class="slideshowHideLink" href="#" onclick="' . $hideCaptionClick . '">' . htmlspecialchars((isset($LANG['HIDE_CAPTION'])?$LANG['HIDE_CAPTION']:'HIDE CAPTION'), ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '</a>';
			$html .= '<div class="slideshowCitationDiv">';
			if($imgIdArr["sciname"] || $imgIdArr["identifier"]){
				$html .= '<a href="' . htmlspecialchars($linkUrl, ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '" target="_blank">' . htmlspecialchars(($imgIdArr["identifier"]?$imgIdArr["identifier"]:$imgIdArr["sciname"]), ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '</a>. ';
			}
			if($imgIdArr["creator"] || $imgIdArr["creatorName"]){
				$html .= (isset($LANG['IMAGE_BY'])?$LANG['IMAGE_BY']:'Image by').': '.($imgIdArr["creator"]?$imgIdArr["creator"]:$imgIdArr["creatorName"]).'. ';
			}
			if($imgIdArr["owner"]){
				$html .= (isset($LANG['COURTESY_OF'])?$LANG['COURTESY_OF']:'Courtesy of').': '.$imgIdArr["owner"].'. ';
			}
			$html .= "</div></div>\n";
			$showCaptionClick = "$('.slideshowCaptionDiv').show();$('.slideshowShowLink').hide();return false;";
			$html .= '<a class="slideshowShowLink" href="#" onclick="' . $showCaptionClick . '">' . htmlspecialchars((isset($LANG['SHOW_CAPTION'])?$LANG['SHOW_CAPTION']:'SHOW CAPTION'), ENT_COMPAT | ENT_HTML401 | ENT_SUBSTITUTE) . '</a>';
			$html .= "</div></div>\n";
		}
		return $html;
	}
}
