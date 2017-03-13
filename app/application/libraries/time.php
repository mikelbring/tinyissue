<?php

class Time {

	/**
	 * Displays the timestamp's age in human readable format
	 *
	 * @param  int $timestamp
	 * @return string
	 * Modified in nov 2016 to include all languages
	 */
	public static function age($timestamp)
	{
		$timestamp = (int) $timestamp;
		$difference = time() - $timestamp;
		$periods = array(__('tinyissue.second'),__('tinyissue.minute'),__('tinyissue.hour'),__('tinyissue.day'),__('tinyissue.week'),__('tinyissue.month'),__('tinyissue.year'),__('tinyissue.decade'));
		$lengths = array('60','60','24','7','4.35','12','10');

		for($j = 0; $difference >= $lengths[$j]; $j++)
		{
			$difference /= $lengths[$j];
		}

		$difference = round($difference);

		if($difference != 1)
		{
			$periods[$j] .= 's';
		}

		return __('tinyissue.since') .  ' '. $difference . ' ' . $periods[$j] . ' ' .  __('tinyissue.ago') . ' ';
	}
}