<?php

	//$apikey = 'sh293hph5b45zzhw9ygt63h8';
	$apikey = '48yfjec72bnfenpjvqf26arq';
	
	
	$start = $start_again;
	$search_word2 = $word;
	//$search_word2 = urlencode($search_word2);
	//$search_word2 = str_replace(" ", "%20", $search_word2);
	$search_word2	= $word."&start=$start";
	$search_word2	= $word."&numItems=25";	
	
	$url = 'http://api.walmartlabs.com/v1/search?apiKey='.$apikey.'&query='.$search_word2.'&format=json';
	$url = str_replace(" ", "%20", $url);

	
	//$walmart_match = $walmart_match_starting;
	if($json = file_get_contents($url)){
	
		$keywords = json_decode($json);
		//echo '<pre>';print_r($keywords);

	
	   
		$i = 0;
		if ($keywords->numItems <= 0) {
			//echo "No data found";
		}else{
			$results_flag_update = 1;
			$numItems = $keywords->numItems;  	
			$results = '';			
			for($i=0;$i<$numItems;$i++){
								
				$walmart_match_starting = 0;
				$walmart_match = 0;
				
				$name = $keywords->items[$i]->name;
				$largeImage = $keywords->items[$i]->largeImage;	
				$itemId = $keywords->items[$i]->itemId;	
				$salePrice= $keywords->items[$i]->salePrice; 
				$productUrl = $keywords->items[$i]->productUrl;				
				//$modelNumber= $keywords->items[$i]->modelNumber;
				//$shortDescription = $keywords->items[$i]->shortDescription;
				//$longDescription= $keywords->items[$i]->longDescription;				
									
				//$stock = $keywords->items[$i]->stock;			
				//$customerRating = $keywords->items[$i]->customerRating;	
				//$numReviews = $keywords->items[$i]->numReviews;				
				//$longDescription= substr($longDescription, 0, 150);			
				
				require("walmart_to_ebay.php");
				
				if( $walmart_match >= 60){

					$walmart_profit = " ";
					$ebay_profit = " ";

					$walmart_percentange = 0.3;
					$ebay_percentange = 0.3;


					
					if($salePrice < $currentPrice){
						$ebay_profit = $currentPrice - $salePrice - $salePrice*$walmart_percentange - $currentPrice*$ebay_percentange;

						$ebay_profit = round($ebay_profit,2);						
					}else{

						$walmart_profit = $salePrice - $currentPrice - $salePrice*$walmart_percentange - $currentPrice*$ebay_percentange;
						$walmart_profit = round($walmart_profit,2);	
					}
					$results_flag_update = 1;
					$results .= "<tr>						
						<td>$walmart_match</td>												
						<td><a href=\"$productUrl\" target=\"_blank\" >$name</a></td>
						<td><a href=\"$link\" target=\"_blank\">$title</a></td>

						<td><img src=\"$largeImage\" width=\"150px\" height=\"150px\"></td>				
						<td><img src=\"$pic\" width=\"150px\" height=\"150px\"></td>				
						
						<td>$salePrice</td>	
						<td>$currentPrice</td>
						<td>$ebay_profit</td>
						<td>$walmart_profit</td>								
										
					</tr>";					
				
				}			
			
			}		   
		}
	}

   ?>
   
