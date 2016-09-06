<?php
class CommonDreamsBridge extends FeedExpander {

	const MAINTAINER = "nyutag";
	const NAME = "CommonDreams Bridge";
	const URI = "http://www.commondreams.org/";
	const DESCRIPTION = "Returns the newest articles.";

	public function collectData(){
		$this->collectExpandableDatas('http://www.commondreams.org/rss.xml', 10);
	}

	protected function parseItem($newsItem){
		$item = $this->parseRSS_2_0_Item($newsItem);
		$item['content'] = $this->CommonDreamsExtractContent($item['uri']);
		return $item;
	}

	private function CommonDreamsExtractContent($url) {
		if($this->get_cached_time($url) <= strtotime('-24 hours'))
			$this->remove_from_cache($url);
		$html3 = $this->get_cached($url);
		$text = $html3->find('div[class=field--type-text-with-summary]', 0)->innertext;
		$html3->clear();
		unset ($html3);
		return $text;
	}
}
