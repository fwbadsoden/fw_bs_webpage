<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Searchengine extends CP_Controller 
{    
    private $search_index;
    
	/**
	 * Searchengine::__construct()
	 * 
	 * @return
	 */
	public function __construct()
	{
		parent::__construct();
        $this->search_index = APPPATH . 'cache/search_index/index';

        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8());
	}   
    
    public function build_index()
    {
        // Index erstellen, bisheriger Index wird gelöscht
        $index = Zend_Search_Lucene::create($this->search_index);
        
        $this->db->where('online', 1);
        $query = $this->db->get('v_einsatz');
        foreach($query->result() as $row)
        {
            // neues Suchindex-Dokument erzeugen
            $doc = new Zend_Search_Lucene_Document();
            
            // Titel für die Anzeige in der Ergebnisliste
            $doc->addField(Zend_Search_Lucene_Field::Text('title', htmlentities($row->name)));
            // mit diesem Pfad wird das Suchergebnis verknüpft
 			$doc->addField(Zend_Search_Lucene_Field::Text('path', base_url('aktuelles/einsatz/'.$row->einsatzID)));
            // dieser Inhalt wird neben dem Titel indexiert
            $doc->addField(Zend_Search_Lucene_Field::UnStored('content', htmlentities($row->lage.$row->bericht.$row->weitere_kraefte.$row->ort)));
            // zum Index hinzufügen
            $index->addDocument($doc);
            
            echo 'Einsatz ' . $row->name . ' zum Index hinzugefügt.<br />';
        }
        
        // Index optimieren
        $index->optimize();
    }	
    function result() 
    {
		$data['results'] = array();
 
		// falls der "search_query"-Parameter übergeben wurde Suche ausführen
		if ($this->input->post('search_query')) {
			// Index analysieren; Suchergebnisse auslesen
			$index = Zend_Search_Lucene::open($this->search_index);
			$data['results'] = $index->find(htmlentities($this->input->post('search_query')));
		}
		// View mit Suchergebnissen anzeigen
		$this->load->view('frontend/searchengine/searchresults', $data);
	}
    
}
/* End of file searchengine.php */
/* Location: ./application/controllers/searchengine/searchengine.php */