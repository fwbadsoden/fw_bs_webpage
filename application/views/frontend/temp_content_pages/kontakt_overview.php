<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->helper('form');
?>

        <div id="MainContent">      
            <div class="article">
                <p>
                    Sollten Sie Fragen zur Feuerwehrarbeit, zum Feuerwehrverein oder Ähnlichem haben können Sie gerne über unten stehendes Formular mit uns in Kontakt treten.<br />
                    Auch haben wir auf diese Seite noch mal alle Kontaktinformationen für Sie zusammengefasst.
                </p>
                <p>Bei konkreten Fragen können Sie direkt auf die unten stehenden Seiten gehen, um weitere Informationen zu erhalten.</p>
                <ul>
                   <!-- <li><a href="<?=base_url('mitmachen')?>">Sie wollen bei der Feuerwehr mitmachen oder die Feuerwehr unterstützen?</a></li>-->
                    <li><a href="<?=base_url('aktuelles/presse')?>">Sie sind von der Presse und haben Fragen an uns?</a></li>
                    <li><a href="<?=base_url('menschen/jugend')?>">Sie oder Ihre Kinder interessieren sich für unsere Jugendfeuerwehr?</a></li>
                </ul>
<? if($this->session->userdata('contact_send') == 'send') : ?>
                <p><strong>Vielen Dank! Wir haben Ihre Anfrage erhalten und werden uns mit Ihnen in Verbindung setzen.</strong></p>
<? endif; ?> 
				<div class="kontaktformularOpener"><p class="link_open active" id="js_openKontakt"><a href="#" rel="js_contact">Kontaktformular öffnen</a></p></div>
				<div class="kontaktformularOpener"><p class="link_close" id="js_closeKontakt"><a href="#" rel="js_contact">Kontaktformular schlie&szlig;en</a></p></div>
                <div class="kontaktformular">
                	<?=form_open(base_url('kontakt/email'))?>
                        <input type="hidden" name="betreff" value="Kontakt über Kontakformular" />
                        <p class="label"><label for="message">Nachricht</label></p>
                        <p class="form"><textarea name="message"></textarea></p>
                        <p class="label"><label for="name">Name</label></p>
                        <p class="form"><input type="text" name="name" value="" /></p>
                        <p class="label"><label for="email">E-Mail Adresse</label></p>
                        <p class="form"><input type="text" name="email" value="" /></p>
                        <p class="label"><label for="telefon">Telefon</label></p>
                        <p class="form"><input type="text" name="telefon" value="" /></p>
                        <p class="button"><input type="submit" name="sendeButton" value="Formular Senden" class="submitButton" /></p>
                    </form>
                </div>
            </div>
        <hr class="clear" />
        </div>    
        <div id="SidebarContent">   
           	<div class="address">
				<h1 class="first">Kontaktadresse</h1>
				<p>Freiwillige Feuerwehr<br/>Bad Soden am Taunus</p>
				<p>Hunsrückstr. 5-7<br/>65812 Bad Soden am Taunus</p>
				<ul>
					<li class="tel">+49 6196 24074</li>
                    <li class="fax">+49 6196 62596</li></li>
					<li class="mail"><a href="mailto:stadtbrandinspektor@feuerwehr-bs.de">Stadtbrandinspektor</a></li>
					<li class="mail"><a href="mailto:wehrfuehrung@feuerwehr-bs.de">Wehrführung</a></li>
					<li class="mail"><a href="mailto:pressestelle@feuerwehr-bs.de">Pressestelle</a></li>
					<li class="mail"><a href="mailto:jugendfeuerwehr@feuerwehr-bs.de">Jugendfeuerwehr</a></li>
					<li class="mail"><a href="mailto:verein@feuerwehr-bs.de">Verein</a></li>
				</ul>
                <br />
			</div>    
		</div>
        <hr class="clear" />

