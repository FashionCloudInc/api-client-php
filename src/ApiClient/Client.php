<?php

namespace WebScraper\ApiClient;

class Client {

	/**
	 * @var HttpClient
	 */
	private $httpClient;

	public function __construct($options) {

		$this->token = $options['token'];
		$this->httpClient = new HttpClient($options);
	}

	/**
	 * Create sitemap
	 *
	 * @param array $sitemap
	 * @return mixed
	 */
	public function createSitemap(array $sitemap) {

		$response = $this->httpClient->post('sitemap', [
			'json' => $sitemap,
		]);
		return $response;
	}

	/**
	 * Get sitemap
	 *
	 * @param $sitemapId
	 * @return mixed
	 */
	public function getSitemap($sitemapId) {

		$response = $this->httpClient->get("sitemap/{$sitemapId}");
		return $response;
	}

	/**
	 * Get sitemaps
	 *
	 * @return PaginationIterator
	 */
	public function getSitemaps() {

		$iterator = new PaginationIterator($this->httpClient, 'sitemaps');
		return $iterator;
	}

	/**
	 * Delete sitemap
	 *
	 * @param $sitemapId
	 * @return mixed
	 */
	public function deleteSitemap($sitemapId) {

		$response = $this->httpClient->delete("sitemap/{$sitemapId}");
		return $response;
	}

	/**
	 * Create scraping job
	 *
	 * @param $scrapingJobConfig
	 * @return mixed
	 */
	public function createScrapingJob($scrapingJobConfig) {

		$response = $this->httpClient->post('scraping-job', [
			'json' => $scrapingJobConfig,
		]);
		return $response;
	}

	/**
	 * get scraping jobs
	 *
	 * @param null $sitemapId
	 * @return PaginationIterator
	 */
	public function getScrapingJobs($sitemapId = null) {

		$options = [];
		if($sitemapId) {
			$options['query']['sitemap_id'] = $sitemapId;
		}

		$iterator = new PaginationIterator($this->httpClient, 'scraping-jobs', $options);
		return $iterator;
	}

	/**
	 * Get scraping job
	 *
	 * @param $scrapingJobId
	 * @return  []
	 */
	public function getScrapingJob($scrapingJobId) {

		$response = $this->httpClient->get("scraping-job/{$scrapingJobId}");
		return $response;
	}

	/**
	 * Delete scraping job
	 *
	 * @param $scrapingJobId
	 * @return mixed
	 */
	public function deleteScrapingJob($scrapingJobId) {

		$response = $this->httpClient->delete("scraping-job/{$scrapingJobId}");
		return $response;
	}

	/**
	 * Download scraping jobs data in a file
	 *
	 * @param $scrapingJobId
	 * @param $outputFile
	 */
	public function downloadScrapingJobCSV($scrapingJobId, $outputFile) {

		$this->httpClient->requestRaw('GET', "scraping-job/{$scrapingJobId}/csv", [
			'headers'        => ['Accept-Encoding' => 'gzip'],
			'timeout' => 600.0,
			'save_to' => $outputFile,
		]);
	}

	/**
	 * Download scraping jobs data in a file
	 *
	 * @param $scrapingJobId
	 * @param $outputFile
	 */
	public function downloadScrapingJobJSON($scrapingJobId, $outputFile) {

		$this->httpClient->requestRaw('GET', "scraping-job/{$scrapingJobId}/json", [
			'headers'        => ['Accept-Encoding' => 'gzip'],
			'timeout' => 600.0,
			'save_to' => $outputFile,
		]);
	}

	/**
	 * Get Account information. Main purpose of this is to retrieve page
	 * credit amount
	 *
	 * @return mixed
	 */
	public function getAccountInfo() {

		$response = $this->httpClient->get('account');
		return $response;
	}
}