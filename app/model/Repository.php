<?php

namespace PictureAnalyzer;

use Nette;

abstract class Repository extends Nette\Object
{
    /** @var Nette\Database\Connection */
    protected $connection;
    
    public function __construct(Nette\Database\Connection $db)
    {
        $this->connection=$db;
    }
    
    /** vraci tabulku dat
     *  @return Nette\Database\Table\Selection
     */
    public function getTable()
    {
       preg_match('(\w+)Repository', $this, $matches);
       return $this->connection->table($matches[1]);
    }
    
    /**
     * Vrací všechny řádky z tabulky.
     * @return Nette\Database\Table\Selection
     */
    public function findAll()
    {
        return $this->getTable();
    }
    /**
     * Vrací řádky podle filtru, např. array('name' => 'John').
     * @return Nette\Database\Table\Selection
     */
    public function findBy(array $by)
    {
        return $this->getTable()->where($by);
    }


}