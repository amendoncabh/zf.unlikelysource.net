<?php
class Application_Model_RightColAds
{
	public static function getAds()
	{
		// right column ads
		$ad = <<<EOQ
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5366487936196674";
/* zf_unlikelysource_net */
google_ad_slot = "4635083837";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
EOQ;
		return $ad;
	}
}