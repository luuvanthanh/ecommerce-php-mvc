<?php

class CategoryModel extends BaseModel
{
    CONST TABLE_NAME = 'categories';

    public function getAll($select = ['*'],$orderBys = [],  $limit = 10)
    {
        return $this->all(self::TABLE_NAME, $select, $orderBys, $limit);
    }

    public function findById($id)
    {
        return $this->find(self::TABLE_NAME, $id);
    }

    public function store($data)
    {
        return $this->create(self::TABLE_NAME, $data);
    }

    public function updateData($id, $data)
    {
        return $this->update(self::TABLE_NAME, $id, $data);
    }

    public function destroy($id)
    {
        return $this->delete(self::TABLE_NAME, $id);
    }
}
?>