<?php

class Releases
{

	protected $_releaseUrl = 'https://api.github.com/repos/magento/magento2/releases';

	protected $_output = './releases';

	protected $_versionFileName = 'releases';

	/**
	 * set release url
	 */	
	public function setReleaseUrl($url){
		$this->_releaseUrl = $url;
	}

	/**
	 * get release url
	 */
	public function getReleaseUrl(){
		return $this->_releaseUrl;
	}

	/**
	 * set output path
	 */
	public function setOutput($path){
		$this->_output = $path;
	}

	/**
	 * get output path
	 */
	public function getOutput(){
		return $this->_output;
	}

	/**
	 * get release file path
	 */
	public function getReleaseFilePath($file){
		//versions.json/xml/txt
		return $this->getOutput() . '/' . $file;
	}

	/**
	 * Update releases
	 */
	public function updateReleases(){
		$json = $this->getContentByCRUL($this->getReleaseUrl());
		$releases = json_decode($json, true);
		$versions = [];
		$versionListMode = [];
		$xmlVersions = [];
		foreach ($releases as $_release) {
			if($_release['prerelease'] == 1) continue; //skip preview/prerelease

			$versions[$_release['target_commitish']][] = [
				'v'=> $_release['tag_name'],
				's'=> 'stable',
				'd'=> date("Y-m-d", strtotime($_release['published_at'])),
			];
			$versionListMode[$_release['tag_name']] = [
				'v'=> $_release['tag_name'],
				's'=> 'stable',
				'd'=> date("Y-m-d", strtotime($_release['published_at'])),
			];

		}

		//Sort major version
		krsort($versions);
		krsort($versionListMode);
		
		//Save to files
		$this->saveToJsonFile($versions, 'commitish.json');
		$this->saveToJsonFile($versionListMode, 'releases.json');

		//save to XML file
		$this->saveXmlFile($versionListMode, 'releases.xml');

		//save latest version
		$this->saveToJsonFile($this->getLatestRelease($versionListMode), 'latest.json'); 
		//save to txt file
		$this->saveToFile($this->getLatestRelease($versionListMode, 'txt'), 'latest.txt');
		

	}

	/**
	 * Get latest release
	 */
	public function getLatestRelease($versions, $type = 'array'){
		$latest = reset($versions);
		if($type == 'array'){
			return $latest;
		} else{
			return $latest['v'];

		}
	}

	/**
	 * save json file
	 */
	public function saveToJsonFile($data, $filePath){
		$encodeFile = json_encode($data, JSON_PRETTY_PRINT);
		try {
			file_put_contents($this->getReleaseFilePath($filePath), $encodeFile);
		} catch (Exception $e) {
			
		}

	}

	/**
	 * save general file
	 */
	public function saveToFile($data, $filePath){
		try {
			file_put_contents($this->getReleaseFilePath($filePath), $data);
		} catch (Exception $e) {
			
		}
	}

	/**
	 * save XML file
	 */
	public function saveXmlFile($data, $filePath){
		$xml = new SimpleXMLElement('<releases/>');
		foreach ($data as $_release) {

			$release = $xml->addChild("r");
			$release->addChild('v',$_release['v']);
			$release->addChild('s',$_release['s']);
			$release->addChild('d',$_release['d']);
		}
		$result = $xml->asXML();
		try {
			file_put_contents($this->getReleaseFilePath($filePath), $result);
		} catch (Exception $e) {
			
		}
	}

	/**
	 * pull content by url
	 */
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

    /**
     * save url to file
     */
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
$release->setOutput('./releases');
$release->updateReleases();
