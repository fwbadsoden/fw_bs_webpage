<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $this->load->helper('form');
    $this->load->helper('captcha');
    $vals = array(
        'img_path'    => 'captcha/',
        'img_url'     => base_url('captcha').'/',
        'font_path'   => 'fonts/arial.ttf',
        //'word'        => 'random word',
        'img_width'   => '150',
        'img_height'  => '50',
        'expiration'  => '7200'
    );
    
    $cap = create_captcha($vals);
    $data = array(
        'captcha_time' => $cap['time'],
        'ip_address'   => $this->input->ip_address(),
        'word'         => $cap['word']
    );
    
    $query = $this->db->insert_string('captcha', $data);
    $this->db->query($query);
?>

        <div id="MainContent">      
            <div class="article">
                <p>
                    <strong>Vertretungsberechtigter des Vorstand:</strong> Harald Zengeler <br />
                    Registergericht: Amtsgericht Königstein <br />
                    Registernummer: VR 726 <br />
                    Inhaltlich Verantwortlicher gemäß § 10 Absatz 3 MDStV: Harald Zengeler <br />
                </p>
                <p>
                    <strong>Konzeption, Gestaltung und Programmierung:</strong><br />
                    Programmierung: Habib Pleines, Patrick Ritter<br />
                    Gestaltung und Konzeption: Oliver Annen<br />
                    Fotograf: Philippe Mudra <a href="http://www.pmudra-photography.com" target="_blank">www.pmudra-photography.com</a>
                </p>
                <p>
                    <strong>Pflege der Inhalte:</strong><br />
                    Hauptverantwortlicher: Alexander Zengeler (az)<br />
                    Aktuelles: Marc Bauer (mb), Alexander Zengeler (az)<br />
                    Einsätze: Marc Bauer (mb), Alexander Zengeler (az)<br />
                </p>
                <p>
                    Sämtliche auf dieser Website gezeigten Bilder sind Eigentum der Feuerwehr Bad Soden oder des jeweiligen Fotografen. Die Bilder dürfen nur dann außerhalb dieser Website verwendet werden, wenn der Copyright Hinweis auf den Bildern verbleibt und das Copyright schirftlich erwähnt wird: © Feuerwehr Bad Soden am Taunus / [Name des Fotografen]<br /> 
                    Haftungshinweis:<br />
                    Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.
                </p>
<? if($this->session->userdata('contact_send') == 'send') : ?>
                <p><strong>Vielen Dank! Wir haben Ihre Anfrage erhalten und werden uns mit Ihnen in Verbindung setzen.</strong></p>
<? elseif($this->session->userdata('contact_send') == 'validation_error') : ?>
                <p class="error_msg"><strong><?=validation_errors();?></strong></p>            
<? elseif($this->session->userdata('contact_send') == 'captcha_false') : ?>
                <p class="error_msg"><strong>Bitte geben Sie den Text exakt wie auf dem Bild angegeben ein!</strong></p>                  
<? endif; ?> 
				<div class="kontaktformularOpener"><p class="link_open active" id="js_openKontakt"><a href="#" rel="js_contact">Kontaktformular öffnen</a></p></div>
				<div class="kontaktformularOpener"><p class="link_close" id="js_closeKontakt"><a href="#" rel="js_contact">Kontaktformular schlie&szlig;en</a></p></div>
                <div class="kontaktformular">
                	<?=form_open(base_url('kontakt/email'))?>
                        <input type="hidden" name="betreff" value="Kontakt über Impressum" />
                        <p class="label"><label for="message">Nachricht</label></p>
                        <p class="form"><textarea name="message"></textarea></p>
                        <p class="label"><label for="name">Name</label></p>
                        <p class="form"><input type="text" name="name" value="" /></p>
                        <p class="label"><label for="email">E-Mail Adresse</label></p>
                        <p class="form"><input type="text" name="email" value="" /></p>
                        <p class="label"><label for="telefon">Telefon</label></p>
                        <p class="form"><input type="text" name="telefon" value="" /></p>
                        <p class="label"><label for="captcha_img">Captcha</label></p>
                        <p><?=$cap['image']?></p>
                        <p class="label"><label for="captcha">Bitte den Text abtippen</label></p>
                        <p class="form"><input type="text" name="captcha" value="" /></p>
                        <p class="button"><input type="submit" name="sendeButton" value="Formular Senden" class="submitButton" /></p>
                    </form>
                </div>
            </div>
        <hr class="clear" />
        </div>    
        <div id="SidebarContent">   
           	<div class="address">
				<h1 class="first">Kontaktadresse</h1>
				<p>Freiwillige Feuerwehr<br/>Bad Soden am Taunus e.V.</p>
				<p>Hunsrückstr. 5-7<br/>65812 Bad Soden am Taunus</p>
				<ul>
					<li class="tel">+49 6196 24074</li>
                    <li class="fax">+49 6196 62596</li></li>
					<li class="mail"><a href="mailto:info@feuerwehr-bs.de">info@feuerwehr-bs.de</a></li>
				</ul>
                <br />
			</div>    
		</div>
        <hr class="clear" />

