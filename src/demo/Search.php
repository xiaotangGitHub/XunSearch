<?php

namespace tangpeng\xunsearch;

/**
 * Class Search XunSearch Encapsulation class
 * @author  TangPeng
 * @package xiaotang\search
 */
class Search extends \XS
{
    protected $config = [
        'flushIndex'     => true,       //Refresh the index configuration immediately
        'setFuzzy'       => true,       //Open fuzzy search configuration
        'autoSynonyms'   => true,       //Open automatic synonym search function
    ];
    private $limit = [ 'length' => 10, 'offset' => 0 ];

    /**
     * Search constructor.
     * @param string $file_ini The configuration file of Xun search
     * @param array $config
     */
    public function __construct( $file_ini, array $config = [] )
    {
        parent::__construct( $file_ini );

        if( !empty( $config ) ){
            $this->config = array_merge( $this->config, $config );
        }
    }

    /**
     * @function Get the search results
     * @param $field
     * @return array
     */
    public function search( $field )
    {
        $search_begin = microtime( true );

        $search = $this->getSearch();

        //Open fuzzy search configuration
        $search->setFuzzy($this->config['setFuzzy']);

        //Open automatic synonym search function
        $search->setAutoSynonyms( $this->config['autoSynonyms'] );

        //Get N bar data
        $search->setLimit( $this->limit['length'], $this->limit['offset'] );

        //Query data
        $search->setQuery( $field );

        //Search data
        $data['data'] = $search->search();

        //Get the number of results for the last query
        $data['count'] = $search->getLastCount();

        //If there is no data, get the search hints
        if( $data['count'] < 1 ){
            $data['Prompt'] = $search->getCorrectedQuery();
        }

        //Related search
        $data['relevant'] = $search->getRelatedQuery();

        //The total query time consuming n microseconds
        $data['search_time'] = microtime(true) - $search_begin;

        return $data;
    }

    /**
     * @function Index data added to XunSearch
     * @param array $data
     * @return array
     */
    public function addData( array $data )
    {
        if( !is_array( $data ) ){
            return array( 'err_code' => 10001, 'msg' => 'Index data adding non array' );
        }

        if( count( $data ) == count( $data, 1 ) ){
            //One-dimensional array
            $this->getIndex()->add( new \XSDocument( $data ) );
        }else{
            //Multidimensional array
            foreach( $data as $val ){
                $this->getIndex()->add( new \XSDocument( $val ) );
            }
        }
        $this->refresh();
    }

    /**
     * @function Update the index data with the same primary key value
     * @param array $data
     * @return array
     */
    public function updateData( array $data )
    {
        if( !is_array( $data ) ){
            return array( 'err_code' => 10002, 'msg' => 'Index data adding non array' );
        }

        if( count( $data ) == count( $data, 1 ) ){
            //One-dimensional array
            $this->getIndex()->update( new \XSDocument( $data ) );
        }else{
            //Multidimensional array
            foreach( $data as $val ){
                $this->getIndex()->update( new \XSDocument( $val ) );
            }
        }

        $this->refresh();
    }

    /**
     * @function Deleting index data based on the primary key value
     * @param $primaryKey
     */
    public function delData( $primaryKey )
    {
        if( strpos( $primaryKey ,',' ) !== false ){
            $primaryKey = explode( ",", $primaryKey );
        }
        $this->getIndex()->del( $primaryKey );

        $this->refresh();
    }

    /**
     * @function Configuring the number of data to search
     * @param int $length
     * @param int $offset
     * @return $this
     */
    public function limit( $length = 10, $offset = 0 )
    {
        $this->limit( $length, $offset );
        return $this;
    }

    /**
     * @function Scavenging index data when data is seriously out of sync
     */
    public function clear()
    {
        $this->getIndex()->clean();
        $this->refresh();
    }

    /**
     * @function After the index data is processed, the index data is refreshed immediately to make it effective
     * Index refresh configuration needs to be opened
     */
    private function refresh()
    {
        if( $this->config['flushIndex'] ){
            $this->getIndex()->flushIndex();
        }
    }
}