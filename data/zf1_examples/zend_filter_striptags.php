<?php
require 'Zend/Filter.php';
require 'Zend/Filter/StripTags.php';

$test = array('<p>The quick <b>brown fox</b> jumped <i>over</i> the fence</p>',
			  '<a href="http://example.com" onClick="doEvil()">Click</a>'
			 );
// [array|string $tagsAllowed = null], [array|string $attributesAllowed = null]
$filter = new Zend_Filter_StripTags();
$filter->setTagsAllowed(array('a','p', 'b'));
$filter->setAttributesAllowed(array('href'));
foreach ($test as $item) {
	echo "\n" . $filter->filter($item);
}
?>