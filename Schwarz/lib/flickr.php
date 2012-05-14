<?php
class Flickr
{
	const FLICKR_API_URL = 'http://api.flickr.com/services/rest/?';
 
	/**
	* Flicker から写真を検索して IMG タグを返す関数
	* 
	* @param array  $keyword   画像検索に用いるキーワード
	* @param number $limit     画像取得件数
	* @return string 画像を表示する IMG タグをテキストで返します
	*/
 
	public function setFlickrApikey($key)
	{
		$this->Apikey = $key;
	}
 
	public function getFlickrImage($keyword, $limit = 10, $sizeName = 'small', $attributes = null)
	{
		$query = http_build_query(
		  Array(
			 'method' => 'flickr.photos.search',
			 'api_key' => $this->Apikey,
			 'text' => $keyword,
			 'sort' => 'interestingness-desc',
			 'per_page' => $limit
		  )
		);
		$data = simplexml_load_file(self::FLICKR_API_URL . $query) or die("XML パースエラー");
		$result = "";
		foreach($data->photos as $photos) {
			foreach($photos->photo as $photo){
				$result .= $this->getFlickrElement($photo, $sizeName, $attributes);
			}
		}
		return $result;
	}
	private function getFlickrElement($photo, $sizeName, $attributes)
	{
		$element = '<a href="http://www.flickr.com/photos/'.$photo['owner'].'/'.$photo['id'].'/">';
		$element .= $this->getFlickrImageElement($photo, $sizeName, $attributes);
		$element .= '</a>';
		return $element;
	}
 
	private function getFlickrImageElement($photo, $sizeName, $attributes)
	{
		$element = '<img src="' . $this->getFlickrImageUrl($photo, $sizeName) . '"';
		if(!isset($attributes['alt'])) {
 			$attributes['alt'] = (string) $photo['title'];
		}
		if(!isset($attributes['title'])) {
			$attributes['tltle'] = (string) $photo['title'];
		}
		if(is_array($attributes)) {
			foreach($attributes as $attr => $value) {
				$element .= " {$attr}=\"{$value}\"";
			}
		}
		$element .= '>';
		return $element;
	}
 
	private function getFlickrImageUrl($photo, $sizeName)
	{
		/*
		 * s	small square 75x75
		 * t	thumbnail, 100 on longest side
		 * m	small, 240 on longest side
		 * -	medium, 500 on longest side
		 * z	medium 640, 640 on longest side
		 * b	large, 1024 on longest side*
		 * o	original image, either a jpg, gif or png, depending on source format
		 */
 
		$size = Array(
			'small_square' => '_s',
			'thumbnail' => '_t',
			'small' => '_m',
			'medium' => '',
			'medium2' => '_z',
			'large' => '_b',
			'original' => '_o'
		);
 
		$url = 'http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret']. $size[$sizeName] . '.jpg';
		return $url;
	}
}