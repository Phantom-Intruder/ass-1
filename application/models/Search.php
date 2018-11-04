<?php

class Search extends CI_Model
{

    /**
     * Book number unique id
     * @var int
     */
    public $searchTerm;

    /**
     * Use the stored procedure to get search results
     * @param searchTerm string
     */
    public function search($searchTerm){
        $qry_res    = $this->db->query("SET @p0='" . $searchTerm . "'; CALL `GetBySearchTerm`(@p0);");

        $res        = $qry_res->result();

        $qry_res->next_result(); // Dump the extra resultset.
        $qry_res->free_result(); // Does what it says.

        return $res;
    }
}
