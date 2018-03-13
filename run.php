<?php

class Releases
{

	protected $_releaseUrl = 'https://api.github.com/repos/magento/magento2/releases';

	protected $_output = './versions';

	protected $_versionFileName = 'versions';

	public function setReleaseUrl($url){
		$this->_releaseUrl = $url;
	}

	public function getReleaseUrl(){
		return $this->_releaseUrl;
	}

	public function setOutput($path){
		$this->_output = $path;
	}

	public function getOutput(){
		return $this->_output;
	}

	public function getVersionPath($file){
		//versions.json/xml/txt
		return $this->getOutput() . '/' . $file;
	}

	public function updateVersions(){
		$json = $this->getContentByCRUL($this->getReleaseUrl());
		$releases = json_decode($json, true);
		$versions = [];
		foreach ($releases as $_release) {
			if($_release['prerelease'] == 1) continue;
			$versions[$_release['target_commitish']][] = $_release['tag_name'];
		}
		//Sort major version
		krsort($versions);
		//get latest version
		$versions['latest']  = $this->getLatestVersion($versions);
		
		//Save to files
		$this->saveToJsonFile($versions, 'versions.json');
		//save latest version
		$this->saveToJsonFile([$versions['latest']], 'latest.json'); 
		//save to txt file
		$this->saveToFile($versions['latest'], 'latest.txt');
		// $this->saveToFile($versions, 'xml');

	}

	public function getLatestVersion($versions){
		$major = reset($versions);
		$latest = reset($major);

		return $latest;
	}

	public function saveToJsonFile($data, $filePath){
		$encodeFile = json_encode($data, JSON_PRETTY_PRINT);
		try {
			file_put_contents($this->getVersionPath($filePath), $encodeFile);
		} catch (Exception $e) {
			
		}

	}

	public function saveToFile($data, $filePath){
		try {
			file_put_contents($this->getVersionPath($filePath), $data);
		} catch (Exception $e) {
			
		}
	}

    public function getContentByCRUL($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $content = curl_exec($ch);
        if($content === false)
        {
            echo "Error Number:".curl_errno($ch)."<br>";
            echo "Error String:".curl_error($ch);
        }
        
        curl_close($ch);
        return $content;
    }


	public function saveUrlTo($url, $to){
		$content = $this->getContentByCRUL($url);
		if(!empty($content)){
			try {
				file_put_contents($to, $content); 
			} catch (Exception $e) {
				
			}
		}
	}



}


//////////////////////////RUN/////////////////////////////////////////////

$release = new Releases();
$release->setReleaseUrl('https://api.github.com/repos/magento/magento2/releases');
$release->setOutput('./versions');
$release->updateVersions();
