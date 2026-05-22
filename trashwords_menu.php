<?php
/*
+---------------------------------------------------------------+
|		TRASHWORDS
|		Copyright © Billy Smith
|		Licensed under GPL (http://www.gnu.org/licenses/gpl.txt
		Revision: 1.0
|		Date: 2026-05-22
+---------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { 
	exit; 
}

if (ADMIN == TRUE){
	
	if(file_exists(e_PLUGIN."trashwords_menu/language/".e_LANGUAGE.".php")){
		@require_once(e_PLUGIN."trashwords_menu/language/".e_LANGUAGE.".php");
	}

	// #################################
	// ADD TRASHWORD TO PROFANITY LIST
	// #################################
	if(isset($_POST['save'])){
	
		if(empty($_POST['trashword'])){
			$message = LAN_TW_EMPTY;
//			$message .= '<br/>';
	
		}else{
		
			$trashword = ltrim(str_replace("'","�",$_POST['trashword']));
			$sanitized_word = strip_tags($trashword);
	
			if($pref['profanity_words'] == ''){
				
				$badWords = $sanitized_word;
				
			}else{
	
				$badWords = $pref['profanity_words'].','.$sanitized_word;
					
			}
			$coreConfig = e107::getConfig('core');
	
			$coreConfig->setPref(array('profanity_words' => $badWords));
	
			$coreConfig->save();
		}
	}
//	echo $pref['profanity_words'];
	
	// #################################
	// FORM 			
	// #################################
	$twtext .= "
		<div>
		<form method='post' action='".e_SELF."' id='trashwords_form'>
		<table style='width:100%' class='fborder' cellspacing='0' cellpadding='0'>
		<tr>
			<td style='width:100%; text-align:center; vertical-align:top' class='forumheader3' NOWRAP
			>
				<input class='tbox' type='text' name='trashword' size='20' value='' maxlength='30' /><br>
				<input class='button' type='submit' name='save' value='".LAN_TW_SAVE."' />
				<input class='button' type='submit' name='reset' value='".LAN_TW_CLEAR."' />
			</td>
		</tr>
		</table>
		</form>
		</div>
	";
	if(IsSet($message)){
		$twtext .= "
			<div style='text-align:center'>".$message."</div>
		";
	}
	$ns->tablerender(LAN_TW_TITLE, $twtext, 'trashwords_menu');	
}
?>
