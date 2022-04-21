<?php


namespace App\Models\Traits;

trait Where
{

    private $where = [];
    private string $from = '';
    private $columns = [];
    private $orders = [];
    private int $limit = 0;
    private int $offset = 0;
    private $sql = '';
    private string $orderByDesc = '';



    public function orderByDesc(string $field): static
    {
        $this->orderByDesc = $field;
        return $this;
    }

    public function where(...$args): static
    {
//        where('id','>=','name')
//        where('And','id','>=','name')

        $this->where = array_merge($this->where, $args);
        return $this;
    }


    protected function hasWhere()
    {
        return (bool)$this->where;
    }

    public function from(string $table): static
    {
        $this->from = $table;
        return $this;
    }

    public function columns(...$columns): static
    {
//        columns will be array

        $this->columns = array_merge($this->columns, $columns);
        return $this;
    }

    public function orderBy($orders = []): static
    {

        $this->orders = array_merge($this->orders, $orders);
        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): static
    {
        $this->offset = $offset;
        return $this;
    }

    protected function hasFrom(): bool
    {
        return (bool)$this->from;
    }

    protected function hasColumns(): bool
    {
        return (bool)$this->columns;
    }

    protected function hasOrders(): bool
    {
        return (bool)$this->orders;
    }
}