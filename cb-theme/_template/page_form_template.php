<?php/*+------------------------------------------------------------------------------+|     CoreBeat SyStem Manager||     Creator: Gabu||     Revision: v000|     Date: 2012. 10. 09.+------------------------------------------------------------------------------+*/if ( !defined('H-KEI') ) { exit; }$MODULEBODY = "	<h1 class='title'>Kapcsolat</h1>	<hr class='title' />	<div class='pageContent formContent'>	<form name='form_connect' action='' method='POST'>			<p><span class='rowText'>*Küldő neve: </span><span class='rowData'><input type='text' name='name' value='{#DEFNAME}' /></span></p>		<p><span class='rowText'>*Küldő e-mail címe: </span><span class='rowData'><input type='text' name='email' value='{#DEFEMAIL}' /></span></p>		<p><span class='rowText'>Telefonszám: </span><span class='rowData'><input type='text' name='telephone' value='{#DEFTELEPHONE}' /></span></p>				<p><span class='rowText'>*Üzenet: </span><span class='rowData'><textarea name='message'></textarea></span></p>				<input type='submit' name='sendConnectForm' value='Küldés' /> (* Kötelező)	</form>	</div>	";?>