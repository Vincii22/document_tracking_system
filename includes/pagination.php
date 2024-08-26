<?php
 
// This is a helper class to make paginating
// records easy.
class Pagination {
    public $current_page;
    public $per_page;
    public $total_count;
    public $page1;
    public $page2;
    public $page3;
    public $page4;
    public $page5;


    public function __construct($page=1, $per_page=20, $total_count=0){
        $this->current_page = (int)$page;
        $this->per_page = (int)$per_page;
        $this->total_count = (int)$total_count;

        $base = (int)(($this->current_page-1)/5) * 5;
        $this->page1=$base+1;
        $this->page2=$base+2;
        $this->page3=$base+3;
        $this->page4=$base+4;
        $this->page5=$base+5;
    }

    public function offset() {
        return ($this->current_page - 1) * $this->per_page;
    }

    public function total_pages() {
        return ceil($this->total_count/$this->per_page);
    }

    public function previous_page() {
        return $this->current_page - 1;
    }

    public function next_page() {
        return $this->current_page + 1;
    }

    public function has_previous_page() {
        return $this->previous_page() >= 1 ? true : false;
    }

    public function has_next_page() {
        return $this->next_page() <= $this->total_pages() ? true : false;
    }


}


?>