<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$this->load->helper('form');
$this->load->helper('captcha');
$this->load->library('session');
?>

<div class="article">
    <p>Die Pressestelle der Feuerwehr Bad Soden am Taunus ist für die interne und externe Presse- und Öffentlichkeitsarbeit zuständig. Sie berichtet über alle nennenswerten Einsätze der Feuerwehr und steht für 
        eine offene und schnelle Kommunikation mit den Medien und deren Mitarbeitern. Ebenso gehört die Information der Bevölkerung über alltägliche Gefahren im Rahmen von Veröffentlichungen und Veranstaltungen 
        mit dazu.</p>
    <p>Bei presserelevanten Ereignissen steht ein Feuerwehr-Pressesprecher für die Medien bereit und versorgt diese mit Pressemitteilungen, Informationen und ggf. Bildmaterial. 
        Gerne beantworten wir Ihre Presseanfragen, koordinieren Interviewwünsche und betreuen Ihre Fernseh-, Hörfunk- und Internetbeiträge. Wir bieten allen 
        Redaktionen an, Sie in unseren Presse e-Mail Verteiler aufzunehmen.</p>
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
        <?= form_open(base_url('aktuelles/presse/anfrage')) ?>
        <p>
            <select name="betreff">
                <option value="Verteiler Anfrage">Anfrage zur Aufnahme in den Presseverteiler</option>
                <option value="Interview Anfrage">Anfrage für ein Interview</option>
                <option value="Sonstige Anfrage">Anfrage zu einerm anderen Thema</option>
            </select>
        </p>
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

<?php if (strpos(current_url(), 'captcha') !== false || strpos(current_url(), 'validierung') !== false) { ?>
    <script type="text/javascript">
        $("#js_openKontakt").removeClass('active');
        $("#js_closeKontakt").addClass('active');
        $(".kontaktformular").css('display', 'block');
    </script>
    <?php
}
$this->session->unset_userdata(array("form_name", "form_email", "form_message", "form_telefon", "form_redaktion", "form_telefon", 'form_validation_errors'));

