<?php

namespace Fortec;

use Goutte\Client as GoutteClient;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Navigate Github's trending page.
 * 
 * @author Olumide Falomo <olumightyfalomo@gmail.com>
 */
class GithubTrending
{

	/**
	 * @var \Goutte\Client
	*/
	protected $client;

	public function __construct(){
		$this->client = new GoutteClient();
	}

	/**
	 * Get all trending repos
	 * 
	 * @return array
	*/
	public function getTrending(){
		$crawler = $this->client->request('GET', $this->githubUrl());

		$response = $this->parseResponse($crawler);

		return $response;
	}

	/**
	 * Parse the crawler response.
	 * 
	 * Retrieve all the repos from Github's trending page, 
	 * crawl through and extract their details.
	 * 
	 * @param \Symfony\Component\DomCrawler\Crawler $crawler
	 * @return array
	*/
	public function parseResponse(Crawler $crawler){
		$responseData = [];

		$crawler->filter('ol.repo-list li')->each(function($node) use (&$responseData) {

			// e.g. facebook / react
			$title = $this->toString($node->filter('h3')->extract('_text'));

			// Strip all whitepace from the title e.g. facebook/react
			$nameAndRepo = str_replace(' ', '', $title);
			// Change the NameAndRepo to an array e.g. ['facebook', 'react']
			$nameAndRepoArray = explode("/", $nameAndRepo);

			$starLink = '/' . $nameAndRepo . '/stargazers';
			$starHrefAttr = '[href="' . $starLink . '"]';

			$forkLink = '/' . $nameAndRepo . '/network';
			$forkHrefAttr = '[href="' . $forkLink . '"]';

			$description = $this->toString($node->filter('.py-1 > p')->extract('_text')) ?: '';
			$language = $this->toString($node->filter('[itemprop=programmingLanguage]')->extract('_text'));

			$stars = $this->toString($node->filter($starHrefAttr)->extract('_text')) ?: "0";
			$forks = $this->toString($node->filter($forkHrefAttr)->extract('_text')) ?: "0";

			$starsToday = $this->toString($node->filter('span.d-inline-block.float-sm-right')->extract('_text'));

			$data = [
				'author' => $nameAndRepoArray[0],
				'name' => $nameAndRepoArray[1],
				'url' => "https://github.com/" . $nameAndRepo,
				'description' => $description,
				'language' => $language,
				'stars' => $stars,
				'forks' => $forks,
				'starsToday' => $starsToday,
			];

			array_push($responseData, $data);

		});

		return $responseData;
	}

	/**
	 * Convert the document text to a string
	 * 
	 * Since the extract() method returns an array,
	 * we would convert that array into its own string,
	 * and trim the string.
	 * 
	 * @param array
	 * @return string
	*/
	public function toString($arr){
		return trim(implode(' ', $arr));
	}

	/**
	 * Github's trending page url
	 * 
	 * @return string
	*/
	protected function githubUrl(){
		return "https://github.com/trending/?since=daily";
	}

}