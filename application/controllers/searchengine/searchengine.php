<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Searchengine extends CP_Controller 
{
    private $search_index;
    
	public function __construct()
	{
		parent::__construct();
        $this->load->library('zend');
		$this->zend->load('ZendSearch/Lucene/Lucene');
        
        // Suchindex festlegen
        $this->search_index = APPPATH . 'cache/search_index/index';
	}   
    
    public function index()
    {
		$this->load->view('search_view');
	} 
    
    public function index_it() 
    {
        if($this->input->get('index_id') == '8730eeacceaf4f0b071d1c3a5d659f5a1361e817a25a0090db4815501d')
        {
    		// Index erstellen (bisheriger Index wird gelöscht)
    		$index = Zend_Search_Lucene::create($this->search_index);
     
    		// Content, der indexiert werden soll aus DB auslesen
    		$query = $this->db->get('news');
     
    		// Alle Content-Instanzen zum Index hinzufügen
    		foreach ($query->result() as $item) {
    			// Lucene Document für diese Content-Instanz erstellen
    			$doc = new Zend_Search_Lucene_Document();
     
    			// dieser Titel wird in den Suchergebnissen angezeigt
    			$doc->addField(Zend_Search_Lucene_Field::Text('title', $item->title));
    			// mit diesem Pfad werden die Suchergebnisse verknüpft
    			$doc->addField(Zend_Search_Lucene_Field::Text('path', '/brand/'.$item->parent.'/' . $item->slug.'/'));
    			// dieser Inhalt wird neben dem Titel indexiert
    			$doc->addField(Zend_Search_Lucene_Field::UnStored('content', $item->content));
     
    			// zum Index hinzufügen
    			$index->addDocument($doc);
     
    			echo 'Added ' . $article->title . ' to index.<br />';
    		}
     
    		$index->optimize();
        }
	}
 
	public function result() 
    {
		$data['results'] = array();
 
		// falls der "search_query"-Parameter übergeben wurde Suche ausführen
		if ($this->input->post('search_query')) {
			// Index analysieren; Suchergebnisse auslesen
			$index = Zend_Search_Lucene::open($this->search_index);
			$data['results'] = $index->find($this->input->post('search_query'));
		}
		// View mit Suchergebnissen anzeigen
		$this->load->view('search_view', $data);
	}
}
?>