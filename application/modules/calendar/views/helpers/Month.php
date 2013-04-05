<?php
/**
 *
 * @author zed
 * @version 
 */
//require_once 'Zend/View/Interface.php';
/**
 * Month helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Calendar_View_Helper_Month
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * @param Zend_Locale $locale
     * @param int month (1 - 12)
     * @param int year
     * @param array show date array('day' => int, 'month' => int, 'year' => int)
     * @param string CSS prefix
     * @return string month in <table> format
     */
    public function month($locale, $month, $year, $showDate = array(), $css = '')
    {
		$days = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
    	$output  = '';
		$output .= $locale->getTranslation($month, 'month');
		$output .= PHP_EOL . '<hr />' . PHP_EOL;
		$output .= '<table class="' . $css . 'calendar_month_class">';
		$output .= '<tr class="' . $css . 'calendar_week_class"><td>&nbsp;</td>';
		// show days of week
		for ($dow = 0; $dow < 7; $dow++) {
			$output .= '<td class="' . $css . 'calendar_day_class">' 
					 . substr($locale->getTranslation($days[$dow], 'day'), 0, 3) 
					 . '</td>';
		}
		$output .= '</tr>' . PHP_EOL;
		// print out days in month
		$date 	 	 = new Zend_Date(array('day' => 1, 'month' => $month, 'year' => $year));
		$dowOne  	 = $date->get(Zend_Date::WEEKDAY_DIGIT);
		$daysInMonth = $date->get(Zend_Date::MONTH_DAYS);
		$maxDays 	 = $daysInMonth + $dowOne;  
		$dayCount 	 = 1;
		$weekCount	 = 1;
		$firstDaySet = FALSE;
		$output .= '<tr class="' . $css . 'calendar_week_class">';
    	// check show date
    	if (isset($showDate['year'])  	 && 
    		isset($showDate['month']) 	 && 
    		$month == $showDate['month'] && 
    		$year == $showDate['year']) {
			for ($day = 0; $day < $maxDays; $day++) {
				if (!$firstDaySet) {
					if ($day == $dowOne) {
						$firstDaySet = TRUE;
					}
				}
				if ($day % 7 == 0)	{
					$output .= '</tr>'
							 . '<tr class="' . $css . 'calendar_week_class">'
					         . PHP_EOL;
					$output .= '<td><a href="/calendar/view/week/select/' . $weekCount++ . '">+</a></td>';
				}
				if ($firstDaySet && $dayCount <= $daysInMonth) {
					if ($dayCount == $showDate['day']) {
						$output .= '<td class="' . $css . 'calendar_selected_day_class">' . $dayCount++ . '</td>';
					} else {
						$output .= '<td class="' . $css . 'calendar_day_class">' . $dayCount++ . '</td>';
					}
				} else {
					$output .= '<td class="' . $css . 'calendar_week_class">&nbsp;</td>';
				}
			}
    	} else {
			for ($day = 0; $day < $maxDays; $day++) {
				if (!$firstDaySet) {
					if ($day == $dowOne) {
						$firstDaySet = TRUE;
					}
				}
				if ($day % 7 == 0)	{
					$output .= '</tr>'
							 . '<tr class="' . $css . 'calendar_week_class">'
					         . PHP_EOL;
					$output .= '<td><a href="/calendar/view/week/select/' . $weekCount++ . '">+</a></td>';
				}
				if ($firstDaySet && $dayCount <= $daysInMonth) {
					$output .= '<td class="' . $css . 'calendar_day_class">' . $dayCount++ . '</td>';
				} else {
					$output .= '<td class="' . $css . 'calendar_week_class">&nbsp;</td>';
				}
			}
    	}
		$output .= '</tr></table>' . PHP_EOL;
    	return $output;
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
