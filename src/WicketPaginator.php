<?php
namespace Wicket;


use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Presenter;

class WicketPaginator
	implements LengthAwarePaginator
{
	protected $self;
	protected $next;
	protected $prev;
	protected $last;
	protected $first;
	protected $total_items;
	protected $total_pages;
	protected $number;
	protected $size;

	/**
	 * WicketPaginator constructor.
	 * @param array|false $response
	 * @throws Exception This does not look like a paginatable JsonAPI response.
	 */
	public function __construct($response)
	{
		if (!array_key_exists('meta', $response)
			|| !array_key_exists('links', $response)
			|| !array_key_exists('page', $response['meta'])
		) {
			throw new Exception('Required information structure for pagination not met: ' . $response);
		}

		$this->self = in_array('self', $response['links']) ? $response['links']['self'] : null;
		$this->next = in_array('next', $response['links']) ? $response['links']['next'] : null;
		$this->prev = in_array('prev', $response['links']) ? $response['links']['prev'] : null;
		$this->last = in_array('last', $response['links']) ? $response['links']['last'] : null;
		$this->first = in_array('first', $response['links']) ? $response['links']['first'] : null;

		$this->total_items = $response['meta']['page']['total_items'];
		$this->total_pages = $response['meta']['page']['total_pages'];
		$this->number = $response['meta']['page']['number'];
		$this->size = $response['meta']['page']['size'];
	}

	/**
	 * Determine the total number of items in the data store.
	 *
	 * @return int
	 */
	public function total()
	{
		return $this->total_items;
	}

	/**
	 * Get the page number of the last available page.
	 *
	 * @return int
	 */
	public function lastPage()
	{
		return $this->total_pages;
	}

	/**
	 * Get the URL for a given page.
	 *
	 * @param  int $page
	 * @return string
	 */
	public function url($page)
	{
		// TODO: Implement url() method.
	}

	/**
	 * Add a set of query string values to the paginator.
	 *
	 * @param  array|string $key
	 * @param  string|null $value
	 * @return $this
	 */
	public function appends($key, $value = null)
	{
		// TODO: Implement appends() method.
	}

	/**
	 * Get / set the URL fragment to be appended to URLs.
	 *
	 * @param  string|null $fragment
	 * @return $this|string
	 */
	public function fragment($fragment = null)
	{
		// TODO: Implement fragment() method.
	}

	/**
	 * The the URL for the next page, or null.
	 *
	 * @return string|null
	 */
	public function nextPageUrl()
	{
		return $this->next;
	}

	/**
	 * Get the URL for the previous page, or null.
	 *
	 * @return string|null
	 */
	public function previousPageUrl()
	{
		return $this->prev;
	}

	/**
	 * Get all of the items being paginated.
	 *
	 * @return array
	 */
	public function items()
	{
		// TODO: Implement items() method.
	}

	/**
	 * Get the "index" of the first item being paginated.
	 *
	 * @return int
	 */
	public function firstItem()
	{
		// TODO: Implement firstItem() method.
	}

	/**
	 * Get the "index" of the last item being paginated.
	 *
	 * @return int
	 */
	public function lastItem()
	{
		// TODO: Implement lastItem() method.
	}

	/**
	 * Determine how many items are being shown per page.
	 *
	 * @return int
	 */
	public function perPage()
	{
		return $this->size;
	}

	/**
	 * Determine the current page being paginated.
	 *
	 * @return int
	 */
	public function currentPage()
	{
		return $this->number;
	}

	/**
	 * Determine if there are enough items to split into multiple pages.
	 *
	 * @return bool
	 */
	public function hasPages()
	{
		return $this->next || $this->prev;
	}

	/**
	 * Determine if there is more items in the data store.
	 *
	 * @return bool
	 */
	public function hasMorePages()
	{
		return !!$this->next;
	}

	/**
	 * Determine if the list of items is empty or not.
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		// TODO: Implement isEmpty() method.
	}

	/**
	 * Render the paginator using a given Presenter.
	 *
	 * @param  \Illuminate\Contracts\Pagination\Presenter|null $presenter
	 * @return string
	 */
	public function render(Presenter $presenter = null)
	{
		// TODO: Implement render() method.
	}
}