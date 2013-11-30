<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper('form');
$this->load->helper('captcha');
$this->load->library('session');
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
        <?php if (strpos(current_url(), 'gesendet') !== false) { ?>
            <p><strong>Vielen Dank! Wir haben Ihre Anfrage erhalten und werden uns mit Ihnen in Verbindung setzen.</strong></p>
        <?php } ?>      

        <?php if (strpos(current_url(), 'captcha') !== false) { ?>
            <p class="error_msg"><strong>Bitte geben Sie die im Bild angezeigten Buchstaben und Ziffern korrekt ein!</strong></p>
            <?php
        }
        if (strpos(current_url(), 'validierung') !== false) {
            ?> 
            <p class="error_msg"><strong><?= $this->session->userdata('form_validation_errors') ?></strong></p>
        <?php } ?>
        <div class="kontaktformularOpener"><p class="link_open active" id="js_openKontakt"><a href="#" rel="js_contact">Kontaktformular öffnen</a></p></div>
        <div class="kontaktformularOpener"><p class="link_close" id="js_closeKontakt"><a href="#" rel="js_contact">Kontaktformular schlie&szlig;en</a></p></div>
        <div class="kontaktformular">
            <?= form_open(base_url('impressum/anfrage')) ?>
            <input type="hidden" name="betreff" value="Kontakt über Impressum" />
            <p class="label"><label for="message">Nachricht</label></p>
            <p class="form"><textarea name="message"><?= $this->session->userdata('form_message') ?></textarea></p>
            <p class="label"><label for="name">Name</label></p>
            <p class="form"><input type="text" name="name" value="<?= $this->session->userdata('form_name') ?>" /></p>
            <p class="label"><label for="redaktion">Redaktion / Organisation</label></p>
            <p class="form"><input type="text" name="redaktion" value="<?= $this->session->userdata('form_redaktion') ?>" /></p>
            <p class="label"><label for="email">E-Mail Adresse</label></p>
            <p class="form"><input type="text" name="email" value="<?= $this->session->userdata('form_email') ?>" /></p>
            <p class="label"><label for="telefon">Telefon</label></p>
            <p class="form"><input type="text" name="telefon" value="<?= $this->session->userdata('form_telefon') ?>" /></p>
            <p class="label"><label for="captcha_img">Captcha</label></p>
            <p><?= get_captcha_img() ?></p>
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
            <li class="mail"><?= safe_mailto('info@feuerwehr-bs.de', 'info@feuerwehr-bs.de') ?></li>
        </ul>
        <br />
    </div>    
</div>
<hr class="clear" />

<?php if (strpos(current_url(), 'captcha') !== false || strpos(current_url(), 'validierung') !== false) { ?>
    <script type="text/javascript">
        $("#js_openKontakt").removeClass('active');
        $("#js_closeKontakt").addClass('active');
        $(".kontaktformular").css('display', 'block');
    </script>
    <?php
}
$this->session->unset_userdata(array("form_name", "form_email", "form_message", "form_telefon", "form_redaktion", "form_telefon", 'form_validation_errors'));

